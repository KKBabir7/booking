<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Mail\ContactReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        // Mark all as checked when visiting the list
        ContactMessage::where('is_checked', false)->update(['is_checked' => true]);

        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.contacts.index', compact('messages'));
    }

    public function show(ContactMessage $contact)
    {
        return view('admin.contacts.show', ['message' => $contact]);
    }

    public function reply(Request $request, ContactMessage $contact)
    {
        $request->validate([
            'reply_message' => 'required|string',
        ]);

        $contact->update([
            'reply_message' => $request->reply_message,
            'replied_at' => now(),
        ]);

        // Send Email
        try {
            Mail::to($contact->email)->send(new ContactReply($contact));
            return back()->with('success', 'Reply sent successfully to ' . $contact->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Message saved but email failed to send: ' . $e->getMessage());
        }
    }

    public function destroy(ContactMessage $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Message deleted successfully.');
    }
}
