<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle the favorite status of a room for the authenticated user.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        $user = Auth::user();
        $roomId = $request->room_id;

        $favorite = $user->favorites()->where('room_id', $roomId)->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
        } else {
            $user->favorites()->create(['room_id' => $roomId]);
            $isFavorited = true;
        }

        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'message' => $isFavorited ? 'Room added to favorites.' : 'Room removed from favorites.'
        ]);
    }
}
