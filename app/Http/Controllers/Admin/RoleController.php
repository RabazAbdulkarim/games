<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id')->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')
                    ->where('guard_name', 'web'),
            ],
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol toegevoegd.');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')
                    ->where('guard_name', 'web')
                    ->ignore($role->id),
            ],
        ]);

        $role->update([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol gewijzigd.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol verwijderd.');
    }
}