<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class AdminMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::query()->latest();

        if ($request->filled('status') && array_key_exists($request->input('status'), ContactMessage::STATUSES)) {
            $query->status($request->input('status'));
        }

        if ($request->filled('q')) {
            $term = $request->string('q')->toString();
            $query->where(function ($inner) use ($term) {
                $inner->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('subject', 'like', "%{$term}%")
                    ->orWhere('message', 'like', "%{$term}%");
            });
        }

        return view('admin.messages.index', [
            'items' => $query->paginate(15)->withQueryString(),
            'counts' => [
                'all' => ContactMessage::query()->count(),
                'unread' => ContactMessage::query()->unread()->count(),
                'read' => ContactMessage::query()->status('read')->count(),
                'replied' => ContactMessage::query()->status('replied')->count(),
                'archived' => ContactMessage::query()->status('archived')->count(),
            ],
            'activeStatus' => $request->input('status'),
        ]);
    }

    public function show(ContactMessage $message): View
    {
        $message->markAsRead();

        return view('admin.messages.show', compact('message'));
    }

    public function updateStatus(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:unread,read,replied,archived'],
        ]);

        $message->update([
            'status' => $validated['status'],
            'read_at' => $message->read_at ?? now(),
            'replied_at' => $validated['status'] === 'replied' ? now() : $message->replied_at,
        ]);

        return back()->with('status', 'Message marked as '.$validated['status'].'.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('status', 'Message deleted.');
    }
}
