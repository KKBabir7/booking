<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'cleanliness_rating' => 'required|integer|min:1|max:5',
            'communication_rating' => 'required|integer|min:1|max:5',
            'checkin_rating' => 'required|integer|min:1|max:5',
            'accuracy_rating' => 'required|integer|min:1|max:5',
            'location_rating' => 'required|integer|min:1|max:5',
            'value_rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $overallRating = collect([
            $request->cleanliness_rating,
            $request->communication_rating,
            $request->checkin_rating,
            $request->accuracy_rating,
            $request->location_rating,
            $request->value_rating,
        ])->avg();

        Review::create([
            'room_id' => $request->room_id,
            'user_id' => auth()->id(),
            'rating' => round($overallRating, 2),
            'cleanliness_rating' => $request->cleanliness_rating,
            'communication_rating' => $request->communication_rating,
            'checkin_rating' => $request->checkin_rating,
            'accuracy_rating' => $request->accuracy_rating,
            'location_rating' => $request->location_rating,
            'value_rating' => $request->value_rating,
            'comment' => $request->comment,
            'is_featured' => false,
            'is_fake' => false,
        ]);

        return back()->with('success', 'Your review has been submitted successfully.');
    }
}
