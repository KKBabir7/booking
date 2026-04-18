<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ConferenceHall;
use App\Models\PageSetting;

class ConferenceController extends Controller
{
    public function index()
    {
        $halls = ConferenceHall::with(['bookings' => function($q) {
            $q->whereIn('status', ['confirmed', 'pending', 'pending_review'])->select('id', 'hall_id', 'date', 'check_in', 'check_out', 'status');
        }])->where('status', true)->latest()->get();
        
        $settings = PageSetting::getPage('conference');
        return view('conference', compact('halls', 'settings'));
    }
}
