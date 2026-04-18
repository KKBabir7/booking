<?php

namespace App\Mail;

use App\Models\ContactMessage;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReply extends Mailable
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
        $this->template = EmailTemplate::where('slug', 'admin_reply_sent')->first();

        $body = $this->template->content;
        $body = str_replace('[guest_name]', $this->contactMessage->name, $body);
        $body = str_replace('[subject]', $this->contactMessage->subject ?? 'General Inquiry', $body);
        $body = str_replace('[reply_message]', $this->contactMessage->reply_message, $body);
        $body = str_replace('[original_message]', $this->contactMessage->message, $body);

        $subject = str_replace('[subject]', $this->contactMessage->subject ?? 'General Inquiry', $this->template->subject);

        $this->mailData = [
            'subject' => $subject,
            'body' => $body,
            'primaryColor' => $this->template->primary_color,
            'siteLink' => $this->template->site_link,
            'footerText' => $this->template->footer_text,
            'actionUrl' => $this->template->site_link,
            'actionText' => 'Visit our Website'
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
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
