<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration {
    public function up(): void
    {
        $permission = Permission::firstOrCreate([
            'name' => 'gestionar justificaciones biosync',
            'guard_name' => 'web',
        ]);

        Role::whereIn('name', ['Administrador', 'BioSync Administrador'])
            ->where('guard_name', 'web')
            ->get()
            ->each(function (Role $role) use ($permission) {
                $role->givePermissionTo($permission);
            });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Permission::where('name', 'gestionar justificaciones biosync')
            ->where('guard_name', 'web')
            ->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
