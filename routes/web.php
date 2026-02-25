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


// Route::middleware(['auth'])
//     ->get('/settings', [SettingsController::class,'index'])
//     ->name('settings.index');



Route::middleware('auth')->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/security_settings', [SecurityController::class, 'index'])->name('settings.security_settings.index');
    Route::get('/settings/security_settings/create_user', [CreateUserController::class, 'index'])->name('settings.security_settings.create_user.index');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



//New Code 

//Route::get('/settings', [SettingsController::class,'index'])->name('settings.index');


//Route::middleware(['auth','role:super_admin'])
// ->prefix('settings/security')
//->group(function () {


/* Settings Main Page */
//Route::get('/settings', [SettingsController::class,'index'])->name('settings.index');
/* Security Settings Page */
// Route::get('/settings/security', [SecurityController::class,'index'])->name('settings.security');

/* Security Sub Pages */
//Route::get('/settings/security/create-user', [SecurityController::class,'createUser'])->name('settings.security.create-user');
//Route::get('/settings/security/create-group', [SecurityController::class,'createGroup'])->name('settings.security.create-group');
//Route::get('/settings/security/roles', [SecurityController::class,'roles'])->name('settings.security.roles');
//Route::get('/settings/security/permissions', [SecurityController::class,'permissions'])->name('settings.security.permissions');

//Route::get('/roles', [RoleController::class,'index']);
//Route::post('/roles', [RoleController::class,'store']);

// Route::get('/permissions', [PermissionController::class,'index']);
// Route::post('/permissions', [PermissionController::class,'store']);

// Route::get('/role-permission', [RolePermissionController::class,'edit']);
// Route::post('/role-permission', [RolePermissionController::class,'update']);

// Route::get('/users', [UserController::class,'index']);
// Route::post('/users', [UserController::class,'store']);
// Route::post('/users/{user}/role', [UserController::class,'assignRole']);
// });


require __DIR__ . '/auth.php';
