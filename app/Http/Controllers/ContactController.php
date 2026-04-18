<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminInquiryReceived;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $validated['ip_address'] = $request->ip();

        $contactMessage = ContactMessage::create($validated);

        // Send Email to Admin
        try {
            Mail::to(config('mail.from.address'))->send(new AdminInquiryReceived($contactMessage));
        } catch (\Exception $e) {
            \Log::error('Contact: Failed to send admin inquiry notification: ' . $e->getMessage());
        }

        return back()->with('success', 'Your message has been sent successfully! Our team will get back to you soon.');
    }
}
