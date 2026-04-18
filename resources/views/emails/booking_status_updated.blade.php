<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #f76156; margin: 0; }
        .status-box { text-align: center; background: #fef2f2; padding: 15px; border-radius: 30px; margin-bottom: 30px; border: 1px solid #fecaca; }
        .status-text { font-weight: bold; text-transform: uppercase; color: #dc2626; }
        .details { background: #f8fafc; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .footer { text-align: center; font-size: 12px; color: #64748b; margin-top: 30px; }
        .button { display: inline-block; padding: 12px 24px; background-color: #f76156; color: #fff; text-decoration: none; border-radius: 30px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nice Guest House</h1>
            <p>Booking Status Updated</p>
        </div>
        
        <p>Dear {{ $booking->user->name }},</p>
        <p>The status of your booking <strong>#{{ $booking->id }}</strong> has been updated.</p>
        
        <div class="status-box">
             Current Status: <span class="status-text">{{ $booking->status }}</span>
        </div>
        
        <div class="details">
            <h3 style="margin-top: 0;">Updated Booking Info</h3>
            <p><strong>Item:</strong> {{ $booking->title }}</p>
            <p><strong>Check-in / Date:</strong> {{ \Carbon\Carbon::parse($booking->check_in ?? $booking->date)->format('d M, Y') }}</p>
        </div>
        
        <p>Log in to your dashboard for more details or to manage your reservation.</p>
        
        <div style="text-align: center;">
            <a href="{{ route('account.index') }}" class="button">View Dashboard</a>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Nice Guest House. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
