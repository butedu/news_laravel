<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Permission;
use App\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $permissionNames = [
            'admin.posts.edit',
            'admin.posts.update',
        ];

        $permissions = collect($permissionNames)->map(function (string $name) {
            return Permission::firstOrCreate(['name' => $name]);
        });

        $eligibleRoleNames = ['admin', 'administrator', 'editor'];

        $roles = Role::all()->filter(function (Role $role) use ($eligibleRoleNames) {
            return in_array(strtolower($role->name), $eligibleRoleNames, true);
        });

        if ($roles->isEmpty()) {
            return;
        }

        $permissionIds = $permissions->pluck('id')->all();

        foreach ($roles as $role) {
            $role->permissions()->syncWithoutDetaching($permissionIds);
        }
    }

    public function down(): void
    {
        $permissionNames = ['admin.posts.edit', 'admin.posts.update'];

        $roles = Role::all()->filter(function (Role $role) {
            return in_array(strtolower($role->name), ['admin', 'administrator', 'editor'], true);
        });

        if ($roles->isNotEmpty()) {
            $permissionIds = Permission::whereIn('name', $permissionNames)->pluck('id')->all();
            foreach ($roles as $role) {
                $role->permissions()->detach($permissionIds);
            }
        }

        Permission::whereIn('name', $permissionNames)->delete();
    }
};
