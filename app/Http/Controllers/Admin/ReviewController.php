<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Mark all unread reviews as checked when viewing the list
        Review::where('is_checked', false)->update(['is_checked' => true]);

        // Group reviews by room (Show all rooms so admin can add fake reviews to empty ones)
        $roomsWithReviews = Room::with(['reviews.user' => function($q) { $q->latest(); }])->get();
        return view('admin.reviews.index', compact('roomsWithReviews'));
    }

    public function create()
    {
        $rooms = Room::all();
        $users = User::all();
        return view('admin.reviews.form', compact('rooms', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'nullable|exists:users,id',
            'cleanliness_rating' => 'required|integer|min:1|max:5',
            'communication_rating' => 'required|integer|min:1|max:5',
            'checkin_rating' => 'required|integer|min:1|max:5',
            'accuracy_rating' => 'required|integer|min:1|max:5',
            'location_rating' => 'required|integer|min:1|max:5',
            'value_rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'is_featured' => 'boolean',
            'is_fake' => 'boolean',
            'fake_guest_name' => 'nullable|string',
            'fake_guest_email' => 'nullable|email',
        ]);

        $data = $request->all();
        
        $overallRating = collect([
            $request->cleanliness_rating,
            $request->communication_rating,
            $request->checkin_rating,
            $request->accuracy_rating,
            $request->location_rating,
            $request->value_rating,
        ])->avg();
        
        $data['rating'] = round($overallRating, 2);
        
        // Handle fake review logic
        if ($request->has('is_fake') && $request->is_fake) {
            $data['user_id'] = null; // Ensure user ID is null for fake reviews
        } else {
            $data['is_fake'] = false;
        }

        Review::create($data);
        return redirect()->route('admin.reviews.index')->with('success', 'Review added successfully!');
    }

    public function edit(Review $review)
    {
        $rooms = Room::all();
        $users = User::all();
        return view('admin.reviews.form', compact('review', 'rooms', 'users'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'nullable|exists:users,id',
            'cleanliness_rating' => 'required|integer|min:1|max:5',
            'communication_rating' => 'required|integer|min:1|max:5',
            'checkin_rating' => 'required|integer|min:1|max:5',
            'accuracy_rating' => 'required|integer|min:1|max:5',
            'location_rating' => 'required|integer|min:1|max:5',
            'value_rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'is_featured' => 'boolean',
            'is_fake' => 'boolean',
            'fake_guest_name' => 'nullable|string',
            'fake_guest_email' => 'nullable|email',
        ]);

        $data = $request->all();
        
        $overallRating = collect([
            $request->cleanliness_rating,
            $request->communication_rating,
            $request->checkin_rating,
            $request->accuracy_rating,
            $request->location_rating,
            $request->value_rating,
        ])->avg();
        
        $data['rating'] = round($overallRating, 2);
        
        if ($request->has('is_fake') && $request->is_fake) {
            $data['user_id'] = null;
        } else {
            $data['is_fake'] = false;
        }

        $review->update($data);
        return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully!');
    }
}
