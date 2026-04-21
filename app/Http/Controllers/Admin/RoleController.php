<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::withCount('permissions')->latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissionsByModule = Permission::all()->groupBy('module');
        return view('admin.roles.form', [
            'role' => new Role(),
            'permissionsByModule' => $permissionsByModule,
            'title' => 'Create New Role',
            'method' => 'POST',
            'action' => route('admin.roles.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'required|array'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if ($role->slug === 'super_admin') {
            return redirect()->route('admin.roles.index')->with('error', 'Super Admin role cannot be edited.');
        }

        $permissionsByModule = Permission::all()->groupBy('module');
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.form', [
            'role' => $role,
            'permissionsByModule' => $permissionsByModule,
            'rolePermissions' => $rolePermissions,
            'title' => 'Edit Role: ' . $role->name,
            'method' => 'PUT',
            'action' => route('admin.roles.update', $role)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if ($role->slug === 'super_admin') {
            return redirect()->route('admin.roles.index')->with('error', 'Super Admin role cannot be modified.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'required|array'
        ]);

        $role->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->slug === 'super_admin') {
            return back()->with('error', 'Super Admin role cannot be deleted.');
        }

        $role->delete();
        return back()->with('success', 'Role deleted successfully.');
    }
}
