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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nice Guest House</h1>
            <p>New Inquiry from Website</p>
        </div>
        
        <p>Hello Admin,</p>
        <p>You have received a new message from the contact form.</p>
        
        <div class="details">
            <p><strong>From:</strong> {{ $contactMessage->name }} ({{ $contactMessage->email }})</p>
            <p><strong>Subject:</strong> {{ $contactMessage->subject ?? 'No Subject' }}</p>
            <p><strong>Message:</strong></p>
            <p style="white-space: pre-wrap;">{{ $contactMessage->message }}</p>
        </div>
        
        <p>Please log in to the admin dashboard to reply to this message.</p>
        
        <div class="footer">
            <p>© {{ date('Y') }} Nice Guest House Terminal System</p>
        </div>
    </div>
</body>
</html>
