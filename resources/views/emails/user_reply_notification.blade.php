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
        .reply-box { border-left: 4px solid #f76156; padding: 10px 20px; background: #fff; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nice Guest House</h1>
            <p>Admin Reply to Your Inquiry</p>
        </div>
        
        <p>Dear {{ $contactMessage->name }},</p>
        <p>An administrator has replied to your message regarding: <strong>{{ $contactMessage->subject ?? 'General Inquiry' }}</strong></p>
        
        <div class="details">
            <p><strong>Admin Reply:</strong></p>
            <div class="reply-box">
                <p style="white-space: pre-wrap;">{{ $contactMessage->reply_message }}</p>
            </div>
        </div>
        
        <p>Your Original Message:</p>
        <blockquote style="color: #64748b; font-size: 14px; border-left: 2px solid #cbd5e1; padding-left: 10px;">
            {{ $contactMessage->message }}
        </blockquote>
        
        <p>If you have further questions, you can reply directly to this email.</p>
        
        <div class="footer">
            <p>© {{ date('Y') }} Nice Guest House Terminal System</p>
        </div>
    </div>
</body>
</html>
