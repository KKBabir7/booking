<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::whereIn('role', [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN, 'manager', 'editor', 'staff'])
            ->orWhereHas('roles')
            ->latest()
            ->paginate(10);
            
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.admins.form', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $role = Role::find($request->role_id);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role->slug, // Compatibility
            'is_admin' => true,
        ]);

        $user->roles()->sync([$role->id]);

        return redirect()->route('admin.admin-user.index')->with('success', 'Admin user created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin_user)
    {
        $roles = Role::all();
        $userRoleId = $admin_user->roles->first()?->id;

        return view('admin.admins.form', [
            'admin' => $admin_user,
            'roles' => $roles,
            'userRoleId' => $userRoleId
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin_user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$admin_user->id],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $admin_user->password = Hash::make($request->password);
        }

        $role = Role::find($request->role_id);

        $admin_user->name = $request->name;
        $admin_user->email = $request->email;
        $admin_user->role = $role->slug; // Compatibility
        $admin_user->save();

        $admin_user->roles()->sync([$role->id]);

        return redirect()->route('admin.admin-user.index')->with('success', 'Admin user updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin_user)
    {
        if ($admin_user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        if ($admin_user->email === 'admin@example.com') {
            return back()->with('error', 'The main Super Admin cannot be deleted.');
        }

        $admin_user->delete();
        return back()->with('success', 'Admin user deleted successfully.');
    }
}
