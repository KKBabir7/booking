<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailSetting;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailSettingController extends Controller
{
    public function index()
    {
        $smtpSettings = EmailSetting::where('group', 'smtp')->pluck('value', 'key');
        $userTemplates = EmailTemplate::where('category', 'user')->get();
        $adminTemplates = EmailTemplate::where('category', 'admin')->get();
        
        return view('admin.settings.email', compact('smtpSettings', 'userTemplates', 'adminTemplates'));
    }

    public function updateCredentials(Request $request)
    {
        $validated = $request->validate([
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required',
        ]);

        foreach ($validated as $key => $value) {
            EmailSetting::updateOrCreate(
                ['group' => 'smtp', 'key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'SMTP Credentials updated successfully.');
    }

    public function updateTemplate(Request $request, EmailTemplate $template)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required',
            'primary_color' => 'required|string',
            'site_link' => 'required|url',
            'footer_text' => 'nullable|string',
        ]);

        $template->update($validated);

        return back()->with('success', 'Email Template "' . $template->name . '" updated successfully.');
    }
}
