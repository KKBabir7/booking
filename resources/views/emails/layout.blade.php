<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #334155; margin: 0; padding: 0; background-color: #f8fafc; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f8fafc; padding-bottom: 40px; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; margin-top: 40px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #e2e8f0; }
        
        .header { text-align: center; padding: 40px 20px; background-color: #ffffff; border-bottom: 1px solid #f1f5f9; }
        .logo { font-size: 28px; font-weight: 800; color: {{ $primaryColor ?? '#f76156' }}; text-decoration: none; letter-spacing: -0.5px; }
        .logo span { color: #1e293b; }
        
        .content { padding: 40px 50px; }
        .content h1 { font-size: 22px; font-weight: 800; color: #0f172a; margin-top: 0; margin-bottom: 20px; text-align: center; }
        .content p { font-size: 16px; margin-bottom: 24px; color: #475569; }
        
        .details-box { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-bottom: 30px; }
        .details-box h3 { margin-top: 0; font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; }
        .detail-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; }
        .detail-label { font-weight: 600; color: #64748b; }
        .detail-value { font-weight: 700; color: #1e293b; }
        
        .button-wrapper { text-align: center; margin: 30px 0; }
        .button { display: inline-block; padding: 14px 32px; background-color: {{ $primaryColor ?? '#f76156' }}; color: #ffffff !important; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.1em; transition: all 0.3s ease; box-shadow: 0 10px 15px -3px rgba(247, 97, 86, 0.3); }
        
        .footer { text-align: center; padding: 30px 20px; background-color: #f8fafc; }
        .footer p { font-size: 13px; color: #94a3b8; margin: 5px 0; }
        .social-links { margin-top: 20px; }
        .social-link { color: #94a3b8; text-decoration: none; margin: 0 10px; font-size: 12px; font-weight: 700; }
        
        .divider { height: 1px; background-color: #e2e8f0; margin: 30px 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <a href="{{ $siteLink ?? 'https://niceguesthouse.info' }}" class="logo">
                    Nice<span>GuestHouse</span>
                </a>
            </div>
            
            <div class="content">
                @yield('content')
            </div>
            
            <div class="footer">
                <p>&copy; {{ date('Y') }} Nice Guest House Terminal. All rights reserved.</p>
                <p>{{ $footerText ?? 'Sector-09, Road-02, House-27, Uttara, Dhaka-1230, Bangladesh' }}</p>
                
                <div class="social-links">
                    <a href="{{ $siteLink ?? 'https://niceguesthouse.info' }}" class="social-link">Website</a>
                    <a href="#" class="social-link">Support</a>
                    <a href="#" class="social-link">Privacy</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
