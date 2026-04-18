<x-mail::message>
# Hello, {{ $name }}

Thank you for reaching out to **Nice Guest House**.

{{ $replyMessage }}

<x-mail::panel>
**Your Original Inquiry:**
> {{ $originalMessage }}
</x-mail::panel>

If you have any further questions, feel free to reply to this email or visit our website.

<x-mail::button :url="config('app.url')">
Visit Our Website
</x-mail::button>

Best regards,  
**The Support Team**  
{{ config('app.name') }}
</x-mail::message>
