<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionController extends Controller
{
    public function index()
    {
        $links = DB::table('role_has_permissions')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->select(
                'role_has_permissions.role_id',
                'role_has_permissions.permission_id',
                'roles.name as role_name',
                'permissions.name as permission_name'
            )
            ->orderBy('roles.name')
            ->orderBy('permissions.name')
            ->get();

        return view('admin.role_permissions.index', compact('links'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view(
            'admin.role_permissions.create',
            compact('roles', 'permissions')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'permission_id' => ['required', 'exists:permissions,id'],
        ]);

        $exists = DB::table('role_has_permissions')
            ->where('role_id', $request->role_id)
            ->where('permission_id', $request->permission_id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'permission_id' => 'Deze koppeling bestaat al.',
                ]);
        }

        DB::table('role_has_permissions')->insert([
            'role_id' => $request->role_id,
            'permission_id' => $request->permission_id,
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.role-permissions.index')
            ->with('success', 'Koppeling toegevoegd.');
    }

    public function edit(int $roleId, int $permissionId)
    {
        $link = DB::table('role_has_permissions')
            ->where('role_id', $roleId)
            ->where('permission_id', $permissionId)
            ->first();

        abort_if(!$link, 404);

        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view(
            'admin.role_permissions.edit',
            compact('link', 'roles', 'permissions')
        );
    }

    public function update(
        Request $request,
        int $roleId,
        int $permissionId
    ) {
        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'permission_id' => ['required', 'exists:permissions,id'],
        ]);

        $newRoleId = (int) $request->role_id;
        $newPermissionId = (int) $request->permission_id;

        $sameLink =
            $roleId === $newRoleId &&
            $permissionId === $newPermissionId;

        if (!$sameLink) {
            $exists = DB::table('role_has_permissions')
                ->where('role_id', $newRoleId)
                ->where('permission_id', $newPermissionId)
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'permission_id' => 'Deze koppeling bestaat al.',
                    ]);
            }

            DB::table('role_has_permissions')
                ->where('role_id', $roleId)
                ->where('permission_id', $permissionId)
                ->delete();

            DB::table('role_has_permissions')->insert([
                'role_id' => $newRoleId,
                'permission_id' => $newPermissionId,
            ]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.role-permissions.index')
            ->with('success', 'Koppeling gewijzigd.');
    }

    public function destroy(int $roleId, int $permissionId)
    {
        DB::table('role_has_permissions')
            ->where('role_id', $roleId)
            ->where('permission_id', $permissionId)
            ->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.role-permissions.index')
            ->with('success', 'Koppeling verwijderd.');
    }
}