<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration {
    private $permissions = [
        'gestionar biosync',
        'ver biosync',
        'importar poleos biosync',
        'gestionar empleados biosync',
        'ver reportes biosync',
        'gestionar usuarios biosync',
    ];

    public function up(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissionModels = collect();

        foreach ($this->permissions as $permission) {
            $permissionModels->put(
                $permission,
                Permission::findOrCreate($permission, 'web')
            );
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $roles = [
            'BioSync Administrador' => $this->permissions,
            'BioSync Operador' => [
                'ver biosync',
                'importar poleos biosync',
                'gestionar empleados biosync',
                'ver reportes biosync',
            ],
            'BioSync Consulta' => [
                'ver biosync',
                'ver reportes biosync',
            ],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::findOrCreate($roleName, 'web');
            $role->syncPermissions($permissionModels->only($permissions)->values());
        }

        $administrador = Role::where('name', 'Administrador')->where('guard_name', 'web')->first();
        if ($administrador) {
            $administrador->givePermissionTo($permissionModels->values());
        }

        $encargado = Role::where('name', 'encargado')->where('guard_name', 'web')->first();
        if ($encargado) {
            $encargado->givePermissionTo($permissionModels->only([
                'ver biosync',
                'importar poleos biosync',
                'gestionar empleados biosync',
                'ver reportes biosync',
            ])->values());
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        Role::whereIn('name', [
            'BioSync Administrador',
            'BioSync Operador',
            'BioSync Consulta',
        ])->where('guard_name', 'web')->delete();

        Permission::whereIn('name', $this->permissions)
            ->where('guard_name', 'web')
            ->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
