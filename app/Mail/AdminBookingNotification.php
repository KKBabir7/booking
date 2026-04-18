<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminBookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $template = EmailTemplate::where('slug', 'admin_booking_notification')->first();

        $body = $template->content;
        $body = str_replace('[booking_id]', $this->booking->id, $body);
        $body = str_replace('[item_title]', ($this->booking->room->name ?? $this->booking->title), $body);
        $body = str_replace('[guest_name]', ($this->booking->user->name ?? 'Guest'), $body);
        $body = str_replace('[check_in]', \Carbon\Carbon::parse($this->booking->check_in ?? $this->booking->date)->format('d M, Y'), $body);
        $body = str_replace('[check_out]', $this->booking->check_out ? \Carbon\Carbon::parse($this->booking->check_out)->format('d M, Y') : 'N/A', $body);
        $body = str_replace('[total_amount]', number_format($this->booking->total_price) . ' ' . $this->booking->currency_code, $body);
        $body = str_replace('[amount_paid]', number_format($this->booking->amount_paid) . ' ' . $this->booking->currency_code, $body);

        $subject = str_replace('[booking_id]', $this->booking->id, $template->subject);

        $this->mailData = [
            'subject' => $subject,
            'body' => $body,
            'primaryColor' => $template->primary_color,
            'siteLink' => $template->site_link ?? url('/admin/bookings/' . $this->booking->id),
            'footerText' => $template->footer_text ?? 'Management Alert System - Nice Guest House',
            'actionUrl' => url('/admin/bookings/' . $this->booking->id),
            'actionText' => 'Manage Booking'
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
}
