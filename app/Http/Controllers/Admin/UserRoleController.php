<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserRoleController extends Controller
{
    public function index()
    {
        $links = DB::table('model_has_roles')
            ->join('users', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_type', User::class)
            ->select(
                'model_has_roles.role_id',
                'model_has_roles.model_id',
                'users.name as user_name',
                'users.email as user_email',
                'roles.name as role_name'
            )
            ->orderBy('users.name')
            ->get();

        return view('admin.user_roles.index', compact('links'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view(
            'admin.user_roles.create',
            compact('users', 'roles')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $exists = DB::table('model_has_roles')
            ->where('role_id', $request->role_id)
            ->where('model_type', User::class)
            ->where('model_id', $request->user_id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'role_id' => 'Deze gebruiker heeft deze rol al.',
                ]);
        }

        DB::table('model_has_roles')->insert([
            'role_id' => $request->role_id,
            'model_type' => User::class,
            'model_id' => $request->user_id,
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.user-roles.index')
            ->with('success', 'Rol aan gebruiker gekoppeld.');
    }

    public function edit(int $roleId, int $userId)
    {
        $link = DB::table('model_has_roles')
            ->where('role_id', $roleId)
            ->where('model_type', User::class)
            ->where('model_id', $userId)
            ->first();

        abort_if(!$link, 404);

        $users = User::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view(
            'admin.user_roles.edit',
            compact('link', 'users', 'roles')
        );
    }

    public function update(
        Request $request,
        int $roleId,
        int $userId
    ) {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $newUserId = (int) $request->user_id;
        $newRoleId = (int) $request->role_id;

        $sameLink =
            $roleId === $newRoleId &&
            $userId === $newUserId;

        if (!$sameLink) {
            $exists = DB::table('model_has_roles')
                ->where('role_id', $newRoleId)
                ->where('model_type', User::class)
                ->where('model_id', $newUserId)
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'role_id' => 'Deze koppeling bestaat al.',
                    ]);
            }

            DB::table('model_has_roles')
                ->where('role_id', $roleId)
                ->where('model_type', User::class)
                ->where('model_id', $userId)
                ->delete();

            DB::table('model_has_roles')->insert([
                'role_id' => $newRoleId,
                'model_type' => User::class,
                'model_id' => $newUserId,
            ]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.user-roles.index')
            ->with('success', 'Koppeling gewijzigd.');
    }

    public function destroy(int $roleId, int $userId)
    {
        DB::table('model_has_roles')
            ->where('role_id', $roleId)
            ->where('model_type', User::class)
            ->where('model_id', $userId)
            ->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.user-roles.index')
            ->with('success', 'Koppeling verwijderd.');
    }
}