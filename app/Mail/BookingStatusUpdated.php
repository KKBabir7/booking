<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;
use App\Models\EmailTemplate;

class BookingStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $template;
    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->template = EmailTemplate::where('slug', 'booking_status_updated')->first();

        $body = $this->template->content;
        $body = str_replace('[guest_name]', $this->booking->user->name ?? 'Guest', $body);
        $body = str_replace('[booking_id]', $this->booking->id, $body);
        $body = str_replace('[item_title]', $this->booking->title, $body);
        $body = str_replace('[status]', strtoupper($this->booking->status), $body);

        $checkInDate = \Carbon\Carbon::parse($this->booking->check_in ?? $this->booking->date)->format('d M, Y');
        $body = str_replace('[check_in]', $checkInDate, $body);

        $checkOutDate = $this->booking->check_out 
            ? \Carbon\Carbon::parse($this->booking->check_out)->format('d M, Y')
            : $checkInDate;
            
        $body = str_replace('[check_out]', $checkOutDate, $body);

        $currencyService = app(\App\Services\CurrencyService::class);
        $body = str_replace('[total_amount]', $currencyService->format($this->booking->total_price, $this->booking->currency_code), $body);
        $body = str_replace('[amount_paid]', $currencyService->format($this->booking->amount_paid, $this->booking->currency_code), $body);

        $subject = str_replace('[booking_id]', $this->booking->id, $this->template->subject);

        $this->mailData = [
            'subject' => $subject,
            'body' => $body,
            'primaryColor' => $this->template->primary_color,
            'siteLink' => $this->template->site_link,
            'footerText' => $this->template->footer_text,
            'actionUrl' => route('account.index'),
            'actionText' => 'View in Dashboard'
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
