<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration {
    private $permissions = [
        'ver biosync',
        'importar poleos biosync',
        'gestionar empleados biosync',
        'ver reportes biosync',
        'gestionar usuarios biosync',
    ];

    public function up(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ($this->permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

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
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
            $role->syncPermissions($permissions);
        }

        $administrador = Role::where('name', 'Administrador')->where('guard_name', 'web')->first();
        if ($administrador) {
            $administrador->givePermissionTo($this->permissions);
        }

        $encargado = Role::where('name', 'encargado')->where('guard_name', 'web')->first();
        if ($encargado) {
            $encargado->givePermissionTo([
                'ver biosync',
                'importar poleos biosync',
                'gestionar empleados biosync',
                'ver reportes biosync',
            ]);
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
