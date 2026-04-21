<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

trait HasRoles
{
    /**
     * Relationship to Roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission($permissionSlug)
    {
        // Super Admin Bypass
        if ($this->role === 'super_admin' || $this->email === 'admin@example.com') {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role->permissions->contains('slug', $permissionSlug)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($roleSlug)
    {
        return $this->roles->contains('slug', $roleSlug) || $this->role === $roleSlug;
    }

    /**
     * Assign a role to the user
     */
    public function assignRole($role)
    {
        return $this->roles()->syncWithoutDetaching($role);
    }
}
