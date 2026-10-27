@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'canonical' => null,
    'type' => 'website',
    'robots' => null,
    'publishedTime' => null,
    'modifiedTime' => null,
    'author' => null,
    'person' => false,
    'schema' => null,
])

@php
    $siteName = setting('site_name', config('app.name'));
    $defaultTitle = setting('default_meta_title', $siteName.' — '.setting('tagline', ''));
    $metaTitle = $title ? $title.' — '.$siteName : $defaultTitle;
    $metaDescription = $description ?: setting('default_meta_description');
    $ogImage = $image ?: setting('default_og_image');
    $ogImageUrl = $ogImage ? media_url($ogImage) : null;
    $canonicalUrl = $canonical ?: url()->current();

    $structuredData = $schema;

    if (! $structuredData && $person) {
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => setting('profile_name', $siteName),
            'jobTitle' => setting('profile_headline'),
            'description' => setting('profile_short_bio', $metaDescription),
            'url' => url('/'),
        ];

        if ($email = setting('contact_email')) {
            $structuredData['email'] = $email;
        }

        if ($location = setting('profile_location')) {
            $structuredData['address'] = ['@type' => 'PostalAddress', 'addressLocality' => $location];
        }

        $sameAs = \App\Models\SocialLink::query()->active()->ordered()->pluck('url')->all();
        if ($sameAs) {
            $structuredData['sameAs'] = $sameAs;
        }
    }
@endphp

<title>{{ $metaTitle }}</title>
@if ($metaDescription)
    <meta name="description" content="{{ $metaDescription }}">
@endif
@if ($robots)
    <meta name="robots" content="{{ $robots }}">
@endif
<link rel="canonical" href="{{ $canonicalUrl }}">

<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $metaTitle }}">
@if ($metaDescription)
    <meta property="og:description" content="{{ $metaDescription }}">
@endif
<meta property="og:url" content="{{ $canonicalUrl }}">
@if ($ogImageUrl)
    <meta property="og:image" content="{{ $ogImageUrl }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{{ $ogImageUrl }}">
@else
    <meta name="twitter:card" content="summary">
@endif
<meta name="twitter:title" content="{{ $metaTitle }}">
@if ($metaDescription)
    <meta name="twitter:description" content="{{ $metaDescription }}">
@endif

@if ($publishedTime)
    <meta property="article:published_time" content="{{ $publishedTime }}">
@endif
@if ($modifiedTime)
    <meta property="article:modified_time" content="{{ $modifiedTime }}">
@endif
@if ($author)
    <meta property="article:author" content="{{ $author }}">
@endif

@if ($structuredData)
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endif
