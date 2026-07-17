<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BioSyncUserController extends Controller
{
    private const ROLES = [
        'BioSync Administrador',
        'BioSync Operador',
        'BioSync Consulta',
    ];

    public function index(Request $request)
    {
        $users = User::with('roles')
            ->where(function ($query) use ($request) {
                $query->where('id', $request->user()->id)
                    ->orWhereHas('roles', function ($roles) {
                        $roles->whereIn('name', array_merge(self::ROLES, ['Administrador', 'encargado']));
                    });
            })
            ->orderBy('name')
            ->get()
            ->map(function (User $user) {
                $biosyncRole = $user->roles->first(function ($role) {
                    return in_array($role->name, self::ROLES, true);
                });
                $globalRole = $user->roles->first(function ($role) {
                    return in_array($role->name, ['Administrador', 'encargado'], true);
                });

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'rol' => $biosyncRole ? $biosyncRole->name : ($globalRole ? $globalRole->name : null),
                    'rol_biosync' => $biosyncRole ? $biosyncRole->name : null,
                    'es_global' => (bool) $globalRole,
                    'es_actual' => $user->id === auth()->id(),
                    'ultimo_acceso' => $user->updated_at,
                ];
            });

        return response()->json([
            'data' => [
                'usuarios' => $users,
                'roles' => self::ROLES,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $user = User::create([
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole($data['rol']);

        return response()->json([
            'message' => 'Usuario creado y acceso asignado correctamente.',
            'data' => $user->load('roles'),
        ], 201);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate($this->rules($user));
        $attributes = [
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
        ];

        if (!empty($data['password'])) {
            $attributes['password'] = Hash::make($data['password']);
        }

        $user->update($attributes);
        $user->removeRole('BioSync Administrador');
        $user->removeRole('BioSync Operador');
        $user->removeRole('BioSync Consulta');
        $user->assignRole($data['rol']);

        return response()->json([
            'message' => 'Usuario y permisos actualizados correctamente.',
            'data' => $user->load('roles'),
        ]);
    }

    public function revoke(Request $request, User $user)
    {
        if ($request->user()->is($user)) {
            throw ValidationException::withMessages([
                'usuario' => 'No puedes revocar tu propio acceso.',
            ]);
        }

        foreach (self::ROLES as $role) {
            $user->removeRole($role);
        }

        return response()->json([
            'message' => 'Acceso de BioSync revocado correctamente.',
        ]);
    }

    private function rules(User $user = null): array
    {
        $userId = $user ? $user->id : null;
        $passwordRules = $user
            ? ['nullable', 'string', 'min:8', 'confirmed']
            : ['required', 'string', 'min:8', 'confirmed'];

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => $passwordRules,
            'rol' => ['required', Rule::in(self::ROLES)],
        ];
    }
}
