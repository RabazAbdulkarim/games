<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Klant en admin mogen het game-overzicht bekijken
Route::get('/games', [GameController::class, 'index'])
    ->middleware(['auth', 'role:admin|klant']);

// Alleen admin mag games toevoegen, aanpassen en verwijderen
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/games/create', [GameController::class, 'create']);
    Route::post('/games/store', [GameController::class, 'store']);
    Route::get('/games/edit/{id}', [GameController::class, 'edit']);
    Route::post('/games/update/{id}', [GameController::class, 'update']);
    Route::post('/games/destroy/{id}', [GameController::class, 'destroy']);
});

// Beheeromgeving - alleen admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Permissies
        Route::get('/permissions', [PermissionController::class, 'index'])
            ->name('permissions.index');

        Route::get('/permissions/create', [PermissionController::class, 'create'])
            ->name('permissions.create');

        Route::post('/permissions', [PermissionController::class, 'store'])
            ->name('permissions.store');

        Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])
            ->name('permissions.edit');

        Route::put('/permissions/{permission}', [PermissionController::class, 'update'])
            ->name('permissions.update');

        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])
            ->name('permissions.destroy');

        // Rollen
        Route::get('/roles', [RoleController::class, 'index'])
            ->name('roles.index');

        Route::get('/roles/create', [RoleController::class, 'create'])
            ->name('roles.create');

        Route::post('/roles', [RoleController::class, 'store'])
            ->name('roles.store');

        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])
            ->name('roles.edit');

        Route::put('/roles/{role}', [RoleController::class, 'update'])
            ->name('roles.update');

        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])
            ->name('roles.destroy');

        // Permissies koppelen aan rollen
        Route::get('/role-permissions', [RolePermissionController::class, 'index'])
            ->name('role-permissions.index');

        Route::get('/role-permissions/create', [RolePermissionController::class, 'create'])
            ->name('role-permissions.create');

        Route::post('/role-permissions', [RolePermissionController::class, 'store'])
            ->name('role-permissions.store');

        Route::get(
            '/role-permissions/{roleId}/{permissionId}/edit',
            [RolePermissionController::class, 'edit']
        )->name('role-permissions.edit');

        Route::put(
            '/role-permissions/{roleId}/{permissionId}',
            [RolePermissionController::class, 'update']
        )->name('role-permissions.update');

        Route::delete(
            '/role-permissions/{roleId}/{permissionId}',
            [RolePermissionController::class, 'destroy']
        )->name('role-permissions.destroy');
    });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::get('/geheim', function () {
    return view('geheim');
})->middleware('auth');

require __DIR__.'/auth.php';