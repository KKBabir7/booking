<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $type = $request->query('type');
        
        $query = $user->bookings()->where('status', '!=', 'payment_pending');
        
        if ($type && in_array($type, ['room', 'restaurant', 'conference'])) {
            $query->where('type', $type);
        }
        
        $bookings = $query->latest()->get();
        $favorites = $user->favorites()->with('room')->latest()->get();

        return view('user.account', compact('user', 'bookings', 'favorites', 'type'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['required', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
