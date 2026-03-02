<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CreateUserController, ProfileController, SecurityController, SettingsController};

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('admin.dashboard');


//====================================================
// SETTINGS ROUTES
//====================================================
Route::middleware('auth')->group(function () {
    
    // Settings Main Page
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    
    // Security Settings Main Page
    Route::get('/settings/security_settings', [SecurityController::class, 'index'])->name('settings.security_settings.index');
    
    // Old create user route (keep for backward compatibility)
    Route::get('/settings/security_settings/create_user', [CreateUserController::class, 'index'])->name('settings.security_settings.create_user.index');

    //----------------------------------------------------
    // USER MANAGEMENT ROUTES
    //----------------------------------------------------
    Route::prefix('settings/security_settings/users')->name('settings.security_settings.users.')->group(function () {
        Route::get('/', [SecurityController::class, 'userList'])->name('index');
        Route::get('/create', [SecurityController::class, 'createUser'])->name('create');
        Route::post('/', [SecurityController::class, 'storeUser'])->name('store');
        Route::get('/{id}/edit', [SecurityController::class, 'editUser'])->name('edit');
        Route::put('/{id}', [SecurityController::class, 'updateUser'])->name('update');
        Route::delete('/{id}', [SecurityController::class, 'deleteUser'])->name('destroy');
        Route::post('/{id}/reset-password', [SecurityController::class, 'resetPassword'])->name('reset-password');
    });

    //----------------------------------------------------
    // ROLE MANAGEMENT ROUTES
    //----------------------------------------------------
    Route::prefix('settings/security_settings/roles')->name('settings.security_settings.roles.')->group(function () {
        Route::get('/', [SecurityController::class, 'roleList'])->name('index');
        Route::get('/create', [SecurityController::class, 'createRole'])->name('create');
        Route::post('/', [SecurityController::class, 'storeRole'])->name('store');
        Route::get('/{id}/edit', [SecurityController::class, 'editRole'])->name('edit');
        Route::put('/{id}', [SecurityController::class, 'updateRole'])->name('update');
        Route::delete('/{id}', [SecurityController::class, 'deleteRole'])->name('destroy');
        Route::get('/{id}/clone', [SecurityController::class, 'cloneRole'])->name('clone');
    });

    //----------------------------------------------------
    // PERMISSION MANAGEMENT ROUTES
    //----------------------------------------------------
    Route::prefix('settings/security_settings/permissions')->name('settings.security_settings.permissions.')->group(function () {
        Route::get('/', [SecurityController::class, 'permissionList'])->name('index');
        Route::get('/create', [SecurityController::class, 'createPermission'])->name('create');
        Route::post('/', [SecurityController::class, 'storePermission'])->name('store');
        Route::get('/{id}/edit', [SecurityController::class, 'editPermission'])->name('edit');
        Route::put('/{id}', [SecurityController::class, 'updatePermission'])->name('update');
        Route::delete('/{id}', [SecurityController::class, 'deletePermission'])->name('destroy');
    });

    //----------------------------------------------------
    // AJAX ROUTES
    //----------------------------------------------------
    Route::prefix('settings/security_settings/ajax')->name('settings.security_settings.ajax.')->group(function () {
        Route::get('/users-by-role', [SecurityController::class, 'getUsersByRole'])->name('users-by-role');
        Route::get('/role-permissions/{id}', [SecurityController::class, 'getRolePermissions'])->name('role-permissions');
        Route::get('/user-details/{id}', [SecurityController::class, 'getUserDetails'])->name('user-details');
        Route::post('/bulk-assign-role', [SecurityController::class, 'bulkAssignRole'])->name('bulk-assign-role');
    });

    // Profile routes (commented in original, keeping as is)
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php'; 