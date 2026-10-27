<?php

namespace App\Services;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactNotifier
{
    public function notify(ContactMessage $message): void
    {
        $recipient = setting('contact_email', setting('site_email'));

        if (blank($recipient)) {
            return;
        }

        try {
            $body = "New contact message received.\n\n"
                ."Name: {$message->name}\n"
                ."Email: {$message->email}\n"
                .'Phone: '.($message->phone ?: '—')."\n"
                .'Subject: '.($message->subject ?: '—')."\n\n"
                .$message->message."\n";

            Mail::raw($body, function ($mail) use ($recipient, $message) {
                $mail->to($recipient)
                    ->replyTo($message->email, $message->name)
                    ->subject('New contact message: '.($message->subject ?: $message->name));
            });
        } catch (\Throwable $e) {
            Log::warning('Contact notification email failed: '.$e->getMessage());
        }
    }
}
