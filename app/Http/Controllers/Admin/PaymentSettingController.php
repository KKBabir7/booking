<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function index()
    {
        $settings = PaymentSetting::all()->groupBy('group');
        
        // Fetch summaries for the centralized hub
        $roomSummary = \App\Models\Room::select('id', 'name', 'partial_payments')->get();
        $hallSummary = \App\Models\ConferenceHall::select('id', 'name', 'partial_payments')->get();
        $restaurantSummary = \App\Models\Restaurant::where('is_active', true)->get();

        return view('admin.settings.payment', compact('settings', 'roomSummary', 'hallSummary', 'restaurantSummary'));
    }

    public function update(Request $request)
    {
        $settings = $request->except(['_token']);

        foreach ($settings as $key => $value) {
            PaymentSetting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Payment settings updated successfully!');
    }
}
