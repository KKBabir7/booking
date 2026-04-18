<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #f76156; margin: 0; }
        .details { background: #f8fafc; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .footer { text-align: center; font-size: 12px; color: #64748b; margin-top: 30px; }
        .button { display: inline-block; padding: 12px 24px; background-color: #f76156; color: #fff; text-decoration: none; border-radius: 30px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nice Guest House</h1>
            <p>New Booking Confirmation</p>
        </div>
        
        <p>Dear {{ $booking->user->name }},</p>
        <p>Thank you for choosing Nice Guest House. We are pleased to confirm your booking.</p>
        
        <div class="details">
            <h3 style="margin-top: 0;">Booking Details</h3>
            <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
            <p><strong>Item:</strong> {{ $booking->title }}</p>
            <p><strong>Check-in / Date:</strong> {{ \Carbon\Carbon::parse($booking->check_in ?? $booking->date)->format('d M, Y') }}</p>
            @if($booking->type === 'room')
                <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out)->format('d M, Y') }}</p>
            @elseif($booking->type === 'restaurant')
                <p><strong>Time Slot:</strong> {{ $booking->time_slot }}</p>
            @endif
            <p><strong>Guests:</strong> {{ $booking->guests ?? ($booking->adults + $booking->children) }}</p>
            <p><strong>Amount Paid:</strong> {{ app(\App\Services\CurrencyService::class)->format($booking->amount_paid, $booking->currency_code) }}</p>
        </div>
        
        <p>You can view your booking details and status at any time in your dashboard.</p>
        
        <div style="text-align: center;">
            <a href="{{ route('account.index') }}" class="button">Go to Dashboard</a>
        </div>
        
        <p>If you have any questions, feel free to reply to this email or contact our support team.</p>
        
        <div class="footer">
            <p>© {{ date('Y') }} Nice Guest House. All rights reserved.</p>
            <p>Sector-09, Road-02, House-27, Uttara, Dhaka-1230, Bangladesh</p>
        </div>
    </div>
</body>
</html>
