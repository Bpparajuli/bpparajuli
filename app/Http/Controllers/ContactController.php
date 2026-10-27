<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use App\Services\ContactNotifier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('pages.contact');
    }

    public function store(ContactRequest $request, ContactNotifier $notifier): RedirectResponse
    {
        $data = $request->safe()->except('website');

        $message = ContactMessage::query()->create([
            ...$data,
            'status' => 'unread',
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ]);

        $notifier->notify($message);

        return redirect()
            ->route('contact.index')
            ->with('contact_status', 'Thanks for reaching out. Your message has been received and I will get back to you shortly.');
    }
}
