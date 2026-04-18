<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailSetting;
use App\Models\EmailTemplate;

class EmailSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. SMTP Credentials
        $smtpSettings = [
            'mail_mailer' => 'smtp',
            'mail_host' => 'smtp-relay.brevo.com',
            'mail_port' => '587',
            'mail_username' => 'a879ff001@smtp-brevo.com',
            'mail_password' => 'YOUR_BREVO_PASSWORD_HERE',
            'mail_encryption' => 'tls',
            'mail_from_address' => 'kkbabir68@gmail.com',
            'mail_from_name' => 'Nice Guest House',
        ];

        foreach ($smtpSettings as $key => $value) {
            EmailSetting::updateOrCreate(
                ['group' => 'smtp', 'key' => $key],
                ['value' => $value]
            );
        }

        // 2. Default Email Templates
        $templates = [
            [
                'slug' => 'booking_confirmed',
                'name' => 'Booking Confirmation',
                'category' => 'user',
                'subject' => 'Booking Confirmation - Nice Guest House (#[booking_id])',
                'content' => "Dear [guest_name],\n\nThank you for choosing Nice Guest House. We are pleased to confirm your booking for [item_title].\n\nCheck-in: [check_in]\nCheck-out: [check_out]\n\nTotal Amount: [total_amount]\nPaid Amount: [amount_paid]\n\nYou can view your booking details and status at any time in your dashboard.",
                'primary_color' => '#f76156',
            ],
            [
                'slug' => 'booking_status_updated',
                'name' => 'Booking Status Update',
                'category' => 'user',
                'subject' => 'Update on Your Booking (#[booking_id])',
                'content' => "Dear [guest_name],\n\nYour booking for [item_title] has been updated to: [status].\n\nTotal Amount: [total_amount]\nPaid Amount: [amount_paid]\n\nCheck-in: [check_in]\nCheck-out: [check_out]\n\nPlease log in to your dashboard for more details.",
                'primary_color' => '#4f46e5',
            ],
            [
                'slug' => 'admin_inquiry_received',
                'name' => 'New Inquiry Notification',
                'category' => 'admin',
                'subject' => 'New Website Inquiry: [subject]',
                'content' => "Hello Admin,\n\nYou have received a new inquiry from [guest_name] ([guest_email]).\n\nSubject: [subject]\nMessage: [message]",
                'primary_color' => '#10b981',
            ],
            [
                'slug' => 'admin_booking_notification',
                'name' => 'New Booking Alert',
                'category' => 'admin',
                'subject' => 'New Booking Received - Nice Guest House (#[booking_id])',
                'content' => "Hello Admin,\n\nA new booking has been confirmed on the website.\n\nBooking Details:\n- Booking ID: #[booking_id]\n- Service: [item_title]\n- Guest Name: [guest_name]\n- Check-in: [check_in]\n- Check-out: [check_out]\n- Total Amount: [total_amount]\n- Paid Amount: [amount_paid]",
                'primary_color' => '#4f46e5',
            ],
            [
                'slug' => 'admin_reply_sent',
                'name' => 'Inquiry Reply',
                'category' => 'user',
                'subject' => 'Reply to Your Inquiry: [subject]',
                'content' => "Dear [guest_name],\n\nThank you for contacting us. Regarding your message: \"[original_message]\"\n\nOur Team's Reply:\n[reply_message]\n\nIf you have any further questions, feel free to reply to this email.",
                'primary_color' => '#f59e0b',
            ],
            [
                'slug' => 'password_reset',
                'name' => 'Password Reset',
                'category' => 'user',
                'subject' => 'Reset Your Password - Nice Guest House',
                'content' => "Hello [guest_name],\n\nYou are receiving this email because we received a password reset request for your account.\n\nThis password reset link will expire in 60 minutes.\n\nIf you did not request a password reset, no further action is required.",
                'primary_color' => '#4f46e5',
                'site_link' => 'https://niceguesthouse.info',
                'footer_text' => 'Sector-09, Road-02, House-27, Uttara, Dhaka-1230, Bangladesh',
            ],
            [
                'slug' => 'email_verification',
                'name' => 'Email Verification',
                'category' => 'user',
                'subject' => 'Verify Your Email Address - Nice Guest House',
                'content' => "Hello [guest_name],\n\nPlease click the button below to verify your email address.\n\nIf you did not create an account, no further action is required.",
                'primary_color' => '#10b981',
                'site_link' => 'https://niceguesthouse.info',
                'footer_text' => 'Sector-09, Road-02, House-27, Uttara, Dhaka-1230, Bangladesh',
            ]
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }
}
