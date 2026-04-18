<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', User::ROLE_USER);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10);

        // Mark all unread users as checked when viewing the list
        User::where('role', User::ROLE_USER)->where('is_checked', false)->update(['is_checked' => true]);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.form', [
            'user' => new User(),
            'title' => 'Create New User',
            'method' => 'POST',
            'action' => route('admin.users.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

        $user = new User($validated);
        $user->password = bcrypt($request->password);
        $user->role = User::ROLE_USER;
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($user->role !== User::ROLE_USER) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot edit administrative users here.');
        }

        return view('admin.users.form', [
            'user' => $user,
            'title' => 'Edit User: ' . $user->name,
            'method' => 'PUT',
            'action' => route('admin.users.update', $user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($user->role !== User::ROLE_USER) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot update administrative users here.');
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

        $user->fill($request->except('password'));

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $allBookings = $user->bookings()->latest()->get();
        
        $roomBookings = $allBookings->where('type', 'room');
        $restaurantBookings = $allBookings->where('type', 'restaurant');
        $conferenceBookings = $allBookings->where('type', 'conference');

        return view('admin.users.show', compact('user', 'allBookings', 'roomBookings', 'restaurantBookings', 'conferenceBookings'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        if ($user->role !== User::ROLE_USER && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only Super Admin can delete other admins.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
