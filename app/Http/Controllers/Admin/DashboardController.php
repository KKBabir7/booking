<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\ConferenceHall;
use App\Models\User;

use App\Models\Booking;

class DashboardController extends Controller
{
    public function getNotificationCounts()
    {
        return response()->json([
            'unreadBookingsCount' => \App\Models\Booking::where('is_checked', false)
                                    ->where('status', '!=', 'payment_pending')
                                    ->count(),
            'unreadReviewsCount'  => \App\Models\Review::where('is_checked', false)->count(),
            'unreadUsersCount'    => \App\Models\User::where('role', \App\Models\User::class::ROLE_USER)->where('is_checked', false)->count(),
            'unreadContactsCount' => \App\Models\ContactMessage::where('is_checked', false)->count(),
        ]);
    }

    public function index()
    {
        $stats = [
            'rooms_count' => Room::count(),
            'halls_count' => ConferenceHall::count(),
            'users_count' => User::count(),
            'bookings_count' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'revenue' => Booking::where('status', 'confirmed')->sum('total_price'),
        ];
        
        $recentBookings = Booking::with(['user', 'room', 'conferenceHall'])->latest()->take(10)->get();
        
        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}
