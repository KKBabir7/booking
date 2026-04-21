<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Define Permissions grouped by Modules
        $permissions = [
            'Bookings' => [
                'view_bookings' => 'View Bookings',
                'manage_bookings' => 'Manage/Edit Bookings',
                'delete_bookings' => 'Delete Bookings',
                'print_invoices' => 'Print Invoices',
            ],
            'Rooms' => [
                'view_rooms' => 'View Rooms',
                'manage_rooms' => 'Manage/Edit Rooms',
            ],
            'Conference' => [
                'view_conference' => 'View Conference Halls',
                'manage_conference' => 'Manage/Edit Conference Halls',
            ],
            'Restaurant' => [
                'manage_restaurant' => 'Manage Restaurant Settings',
            ],
            'Pages' => [
                'manage_pages' => 'Manage All Page Contents',
                'manage_navbar' => 'Manage Navbar Items',
                'manage_gallery' => 'Manage Gallery',
            ],
            'System' => [
                'manage_seo' => 'Manage SEO/Favicon',
                'manage_currencies' => 'Manage Currencies',
                'manage_payments' => 'Manage Payment Settings',
                'manage_emails' => 'Manage Email Settings/Templates',
                'manage_roles' => 'Manage Roles & Permissions',
                'manage_admins' => 'Manage Admin/Staff Users',
            ],
            'Customers' => [
                'view_users' => 'View Registered Guests',
                'manage_users' => 'Manage Guest Accounts',
                'view_feedbacks' => 'View Reviews & Contact Messages',
                'reply_messages' => 'Reply to Messages/Reviews',
            ]
        ];

        $allPermissionIds = [];

        foreach ($permissions as $module => $modulePermissions) {
            foreach ($modulePermissions as $slug => $name) {
                $permission = Permission::updateOrCreate(
                    ['slug' => $slug],
                    ['name' => $name, 'module' => $module]
                );
                $allPermissionIds[] = $permission->id;
            }
        }

        // Create Super Admin Role
        $superAdminRole = Role::updateOrCreate(['slug' => 'super_admin'], ['name' => 'Super Admin']);
        $superAdminRole->permissions()->sync($allPermissionIds);

        // Create Admin Role
        $adminRole = Role::updateOrCreate(['slug' => 'admin'], ['name' => 'General Admin']);
        // Assign most but not all permissions to Admin if needed, or leave for manual setup
        
        // Assign Super Admin Role to master user
        $masterUser = User::where('email', 'admin@example.com')->first();
        if ($masterUser) {
            $masterUser->roles()->sync([$superAdminRole->id]);
            $masterUser->update(['role' => 'super_admin']);
        }
    }
}
