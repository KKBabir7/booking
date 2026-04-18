<?php

namespace App\Mail;

use App\Models\ContactMessage;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminInquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;
    public $template;
    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
        $this->template = EmailTemplate::where('slug', 'admin_inquiry_received')->first();

        $body = $this->template->content;
        $body = str_replace('[guest_name]', $this->contactMessage->name, $body);
        $body = str_replace('[guest_email]', $this->contactMessage->email, $body);
        $body = str_replace('[subject]', $this->contactMessage->subject ?? 'General Inquiry', $body);
        $body = str_replace('[message]', $this->contactMessage->message, $body);

        $subject = str_replace('[subject]', $this->contactMessage->subject ?? 'General Inquiry', $this->template->subject);

        $this->mailData = [
            'subject' => $subject,
            'body' => $body,
            'primaryColor' => $this->template->primary_color,
            'siteLink' => $this->template->site_link,
            'footerText' => $this->template->footer_text,
            'details' => [
                'Sender' => $this->contactMessage->name,
                'Email' => $this->contactMessage->email,
                'Date' => now()->format('d M, Y H:i'),
            ]
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailData['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.dynamic',
            with: $this->mailData
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
