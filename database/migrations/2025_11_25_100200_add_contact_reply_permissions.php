<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $timestamp = now();

        $permissions = [
            ['name' => 'admin.contacts.show', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'admin.contacts.reply', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        DB::table('permissions')->insert($permissions);

        $newPermissionIds = DB::table('permissions')
            ->whereIn('name', ['admin.contacts.show', 'admin.contacts.reply'])
            ->pluck('id')
            ->all();

        $basePermissionId = DB::table('permissions')
            ->where('name', 'admin.contacts')
            ->value('id');

        if ($basePermissionId) {
            $roleIds = DB::table('permission_role')
                ->where('permission_id', $basePermissionId)
                ->pluck('role_id');

            foreach ($roleIds as $roleId) {
                foreach ($newPermissionIds as $permissionId) {
                    $exists = DB::table('permission_role')
                        ->where('role_id', $roleId)
                        ->where('permission_id', $permissionId)
                        ->exists();

                    if (!$exists) {
                        DB::table('permission_role')->insert([
                            'role_id' => $roleId,
                            'permission_id' => $permissionId,
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissionIds = DB::table('permissions')
            ->whereIn('name', ['admin.contacts.show', 'admin.contacts.reply'])
            ->pluck('id');

        DB::table('permission_role')->whereIn('permission_id', $permissionIds)->delete();

        DB::table('permissions')->whereIn('id', $permissionIds)->delete();
    }
};
