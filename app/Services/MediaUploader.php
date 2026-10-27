<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class MediaUploader
{
    public const ALLOWED_MIMES = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
        'image/svg+xml',
        'application/pdf',
    ];

    public const ALLOWED_EXTENSIONS = [
        'jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'pdf',
    ];

    public const MAX_BYTES = 8388608; // 8 MB

    /**
     * Validate and store an uploaded file on the public disk.
     *
     * @return array{path:string,file_name:string,mime_type:string,size:int,width:?int,height:?int}
     */
    public function store(UploadedFile $file, string $folder = 'uploads'): array
    {
        $this->validate($file);

        $folder = trim($folder !== '' ? $folder : 'uploads', '/');
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'file';
        $fileNumber = 0;

        do {
            $name = $fileNumber === 0
                ? $base.'.'.$extension
                : $base.'-'.($fileNumber + 1).'.'.$extension;
            $fileNumber++;
        } while (Storage::disk('public')->exists($folder.'/'.$name));

        $path = $file->storeAs($folder, $name, 'public');

        $dimensions = @getimagesize(Storage::disk('public')->path($path)) ?: null;

        return [
            'path' => $path,
            'file_name' => $name,
            'mime_type' => $file->getMimeType() ?: $file->getClientMimeType(),
            'size' => $file->getSize(),
            'width' => $dimensions[0] ?? null,
            'height' => $dimensions[1] ?? null,
        ];
    }

    /**
     * Convert a stored raster image to an optimized WebP copy.
     */
    public function toWebp(string $path): ?string
    {
        if (! function_exists('imagewebp')) {
            return null;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return null;
        }

        $absolute = $disk->path($path);
        $mime = @mime_content_type($absolute);

        if (! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return null;
        }

        $image = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($absolute),
            'image/png' => @imagecreatefrompng($absolute),
            'image/webp' => @imagecreatefromwebp($absolute),
            default => null,
        };

        if (! $image) {
            return null;
        }

        $webpPath = preg_replace('/\.[a-z0-9]+$/i', '.webp', $path);
        $webpAbsolute = $disk->path($webpPath);

        if (! is_dir(dirname($webpAbsolute))) {
            mkdir(dirname($webpAbsolute), 0755, true);
        }

        $ok = imagewebp($image, $webpAbsolute, 82);
        imagedestroy($image);

        return $ok ? $webpPath : null;
    }

    protected function validate(UploadedFile $file): void
    {
        if (! $file->isValid()) {
            throw new RuntimeException('The uploaded file is not valid.');
        }

        $extension = strtolower($file->getClientOriginalExtension());

        if (! in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new RuntimeException('This file extension is not allowed.');
        }

        $mime = $file->getMimeType();

        if (! in_array($mime, self::ALLOWED_MIMES, true)) {
            throw new RuntimeException('This file type is not allowed.');
        }

        if ($file->getSize() > self::MAX_BYTES) {
            throw new RuntimeException('The file exceeds the maximum allowed size of 8 MB.');
        }

        // Reject polyglot/executable payloads disguised as images.
        if ($mime === 'image/svg+xml') {
            $contents = (string) file_get_contents($file->getRealPath());
            if (preg_match('/<script|onload\s*=|javascript:/i', $contents)) {
                throw new RuntimeException('This SVG file contains disallowed content.');
            }
        }
    }
}
