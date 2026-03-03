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
// SETTINGS ROUTES (Protected by permission middleware)
//====================================================
Route::middleware(['auth'])->group(function () {

    // Settings Main Page
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    // Security Settings Main Page
    Route::get('/settings/security_settings', [SecurityController::class, 'index'])->name('settings.security_settings.index');

    // Old create user route (keep for backward compatibility)
    Route::get('/settings/security_settings/create_user', [CreateUserController::class, 'index'])->name('settings.security_settings.create_user.index');

    //----------------------------------------------------
    // USER MANAGEMENT ROUTES (Requires: settings.users.manage)
    //----------------------------------------------------
    Route::middleware(['permission:settings.users.manage'])->prefix('settings/security_settings/users')->name('settings.security_settings.users.')->group(function () {
        Route::get('/', [SecurityController::class, 'userList'])->name('index');
        Route::get('/create', [SecurityController::class, 'createUser'])->name('create');
        Route::post('/', [SecurityController::class, 'storeUser'])->name('store');
        Route::get('/{id}/edit', [SecurityController::class, 'editUser'])->name('edit');
        Route::put('/{id}', [SecurityController::class, 'updateUser'])->name('update');
        Route::delete('/{id}', [SecurityController::class, 'deleteUser'])->name('destroy');
        Route::post('/{id}/reset-password', [SecurityController::class, 'resetPassword'])->name('reset-password');
    });

    //----------------------------------------------------
    // ROLE MANAGEMENT ROUTES (Requires: settings.roles.manage)
    //----------------------------------------------------
    Route::middleware(['permission:settings.roles.manage'])->prefix('settings/security_settings/roles')->name('settings.security_settings.roles.')->group(function () {
        Route::get('/', [SecurityController::class, 'roleList'])->name('index');
        Route::get('/create', [SecurityController::class, 'createRole'])->name('create');
        Route::post('/', [SecurityController::class, 'storeRole'])->name('store');
        Route::get('/{id}/edit', [SecurityController::class, 'editRole'])->name('edit');
        Route::put('/{id}', [SecurityController::class, 'updateRole'])->name('update');
        Route::delete('/{id}', [SecurityController::class, 'deleteRole'])->name('destroy');
        Route::get('/{id}/clone', [SecurityController::class, 'cloneRole'])->name('clone');
    });

    //----------------------------------------------------
    // PERMISSION MANAGEMENT ROUTES (Requires: settings.permissions.manage)
    //----------------------------------------------------
    Route::middleware(['permission:settings.permissions.manage'])->prefix('settings/security_settings/permissions')->name('settings.security_settings.permissions.')->group(function () {
        Route::get('/', [SecurityController::class, 'permissionList'])->name('index');
        Route::get('/create', [SecurityController::class, 'createPermission'])->name('create');
        Route::post('/', [SecurityController::class, 'storePermission'])->name('store');
        Route::get('/{id}/edit', [SecurityController::class, 'editPermission'])->name('edit');
        Route::put('/{id}', [SecurityController::class, 'updatePermission'])->name('update');
        Route::delete('/{id}', [SecurityController::class, 'deletePermission'])->name('destroy');
    });

    //----------------------------------------------------
    // AJAX ROUTES (Accessible to all authenticated users with manage permissions)
    //----------------------------------------------------
    Route::prefix('settings/security_settings/ajax')->name('settings.security_settings.ajax.')->group(function () {
        Route::get('/users-by-role', [SecurityController::class, 'getUsersByRole'])->name('users-by-role');
        Route::get('/role-permissions/{id}', [SecurityController::class, 'getRolePermissions'])->name('role-permissions');
        Route::get('/user-details/{id}', [SecurityController::class, 'getUserDetails'])->name('user-details');
        Route::post('/bulk-assign-role', [SecurityController::class, 'bulkAssignRole'])->name('bulk-assign-role');
    });

    // Profile routes
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//====================================================
// PATIENT REGISTRATION MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:patient-registration'])->prefix('patient-registration')->name('patient-registration.')->group(function () {
    Route::get('/', function () { return view('patient-registration.index'); })->name('index')->middleware('permission:patient-registration.view');
    Route::get('/create', function () { return view('patient-registration.create'); })->name('create')->middleware('permission:patient-registration.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:patient-registration.create');
    Route::get('/{id}', function ($id) { return view('patient-registration.show', ['id' => $id]); })->name('show')->middleware('permission:patient-registration.view');
    Route::get('/{id}/edit', function ($id) { return view('patient-registration.edit', ['id' => $id]); })->name('edit')->middleware('permission:patient-registration.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:patient-registration.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:patient-registration.delete');
    Route::get('/{id}/print', function ($id) { return view('patient-registration.print', ['id' => $id]); })->name('print')->middleware('permission:patient-registration.print');
});


//====================================================
// EMERGENCY MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:emergency'])->prefix('emergency')->name('emergency.')->group(function () {
    Route::get('/', function () { return view('emergency.index'); })->name('index')->middleware('permission:emergency.view');
    Route::get('/create', function () { return view('emergency.create'); })->name('create')->middleware('permission:emergency.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:emergency.create');
    Route::get('/{id}', function ($id) { return view('emergency.show', ['id' => $id]); })->name('show')->middleware('permission:emergency.view');
    Route::get('/{id}/edit', function ($id) { return view('emergency.edit', ['id' => $id]); })->name('edit')->middleware('permission:emergency.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:emergency.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:emergency.delete');
});


//====================================================
// OPD (Out Patient Department) MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:opd'])->prefix('opd')->name('opd.')->group(function () {
    Route::get('/', function () { return view('opd.index'); })->name('index')->middleware('permission:opd.view');
    Route::get('/create', function () { return view('opd.create'); })->name('create')->middleware('permission:opd.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:opd.create');
    Route::get('/{id}', function ($id) { return view('opd.show', ['id' => $id]); })->name('show')->middleware('permission:opd.view');
    Route::get('/{id}/edit', function ($id) { return view('opd.edit', ['id' => $id]); })->name('edit')->middleware('permission:opd.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:opd.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:opd.delete');
    Route::get('/{id}/print', function ($id) { return view('opd.print', ['id' => $id]); })->name('print')->middleware('permission:opd.print');
});


//====================================================
// CPD (Clinical Procedure Day) MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:cpd'])->prefix('cpd')->name('cpd.')->group(function () {
    Route::get('/', function () { return view('cpd.index'); })->name('index')->middleware('permission:cpd.view');
    Route::get('/create', function () { return view('cpd.create'); })->name('create')->middleware('permission:cpd.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:cpd.create');
    Route::get('/{id}', function ($id) { return view('cpd.show', ['id' => $id]); })->name('show')->middleware('permission:cpd.view');
    Route::get('/{id}/edit', function ($id) { return view('cpd.edit', ['id' => $id]); })->name('edit')->middleware('permission:cpd.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:cpd.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:cpd.delete');
});


//====================================================
// IPD (In Patient Department) MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:ipd'])->prefix('ipd')->name('ipd.')->group(function () {
    Route::get('/', function () { return view('ipd.index'); })->name('index')->middleware('permission:ipd.view');
    Route::get('/create', function () { return view('ipd.create'); })->name('create')->middleware('permission:ipd.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:ipd.create');
    Route::get('/{id}', function ($id) { return view('ipd.show', ['id' => $id]); })->name('show')->middleware('permission:ipd.view');
    Route::get('/{id}/edit', function ($id) { return view('ipd.edit', ['id' => $id]); })->name('edit')->middleware('permission:ipd.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:ipd.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:ipd.delete');
    Route::get('/{id}/print', function ($id) { return view('ipd.print', ['id' => $id]); })->name('print')->middleware('permission:ipd.print');
});


//====================================================
// IP MINOR MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:ipminor'])->prefix('ipminor')->name('ipminor.')->group(function () {
    Route::get('/', function () { return view('ipminor.index'); })->name('index')->middleware('permission:ipminor.view');
    Route::get('/create', function () { return view('ipminor.create'); })->name('create')->middleware('permission:ipminor.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:ipminor.create');
    Route::get('/{id}', function ($id) { return view('ipminor.show', ['id' => $id]); })->name('show')->middleware('permission:ipminor.view');
    Route::get('/{id}/edit', function ($id) { return view('ipminor.edit', ['id' => $id]); })->name('edit')->middleware('permission:ipminor.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:ipminor.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:ipminor.delete');
});


//====================================================
// DAILY CASE MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:daily-case'])->prefix('daily-case')->name('daily-case.')->group(function () {
    Route::get('/', function () { return view('daily-case.index'); })->name('index')->middleware('permission:daily-case.view');
    Route::get('/create', function () { return view('daily-case.create'); })->name('create')->middleware('permission:daily-case.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:daily-case.create');
    Route::get('/{id}', function ($id) { return view('daily-case.show', ['id' => $id]); })->name('show')->middleware('permission:daily-case.view');
    Route::get('/{id}/edit', function ($id) { return view('daily-case.edit', ['id' => $id]); })->name('edit')->middleware('permission:daily-case.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:daily-case.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:daily-case.delete');
});


//====================================================
// OT MANAGEMENT MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:ot-management'])->prefix('ot-management')->name('ot-management.')->group(function () {
    Route::get('/', function () { return view('ot-management.index'); })->name('index')->middleware('permission:ot-management.view');
    Route::get('/create', function () { return view('ot-management.create'); })->name('create')->middleware('permission:ot-management.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:ot-management.create');
    Route::get('/{id}', function ($id) { return view('ot-management.show', ['id' => $id]); })->name('show')->middleware('permission:ot-management.view');
    Route::get('/{id}/edit', function ($id) { return view('ot-management.edit', ['id' => $id]); })->name('edit')->middleware('permission:ot-management.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:ot-management.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:ot-management.delete');
    Route::get('/{id}/print', function ($id) { return view('ot-management.print', ['id' => $id]); })->name('print')->middleware('permission:ot-management.print');
});


//====================================================
// PHARMACY MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:pharmacy'])->prefix('pharmacy')->name('pharmacy.')->group(function () {
    Route::get('/', function () { return view('pharmacy.index'); })->name('index')->middleware('permission:pharmacy.view');
    Route::get('/create', function () { return view('pharmacy.create'); })->name('create')->middleware('permission:pharmacy.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:pharmacy.create');
    Route::get('/{id}', function ($id) { return view('pharmacy.show', ['id' => $id]); })->name('show')->middleware('permission:pharmacy.view');
    Route::get('/{id}/edit', function ($id) { return view('pharmacy.edit', ['id' => $id]); })->name('edit')->middleware('permission:pharmacy.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:pharmacy.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:pharmacy.delete');
    Route::get('/{id}/print', function ($id) { return view('pharmacy.print', ['id' => $id]); })->name('print')->middleware('permission:pharmacy.print');
});


//====================================================
// DENTAL MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:dental'])->prefix('dental')->name('dental.')->group(function () {
    Route::get('/', function () { return view('dental.index'); })->name('index')->middleware('permission:dental.view');
    Route::get('/create', function () { return view('dental.create'); })->name('create')->middleware('permission:dental.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:dental.create');
    Route::get('/{id}', function ($id) { return view('dental.show', ['id' => $id]); })->name('show')->middleware('permission:dental.view');
    Route::get('/{id}/edit', function ($id) { return view('dental.edit', ['id' => $id]); })->name('edit')->middleware('permission:dental.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:dental.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:dental.delete');
    Route::get('/{id}/print', function ($id) { return view('dental.print', ['id' => $id]); })->name('print')->middleware('permission:dental.print');
});


//====================================================
// PHYSIOTHERAPY MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:physiotherapy'])->prefix('physiotherapy')->name('physiotherapy.')->group(function () {
    Route::get('/', function () { return view('physiotherapy.index'); })->name('index')->middleware('permission:physiotherapy.view');
    Route::get('/create', function () { return view('physiotherapy.create'); })->name('create')->middleware('permission:physiotherapy.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:physiotherapy.create');
    Route::get('/{id}', function ($id) { return view('physiotherapy.show', ['id' => $id]); })->name('show')->middleware('permission:physiotherapy.view');
    Route::get('/{id}/edit', function ($id) { return view('physiotherapy.edit', ['id' => $id]); })->name('edit')->middleware('permission:physiotherapy.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:physiotherapy.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:physiotherapy.delete');
    Route::get('/{id}/print', function ($id) { return view('physiotherapy.print', ['id' => $id]); })->name('print')->middleware('permission:physiotherapy.print');
});


//====================================================
// LAB MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:lab'])->prefix('lab')->name('lab.')->group(function () {
    Route::get('/', function () { return view('lab.index'); })->name('index')->middleware('permission:lab.view');
    Route::get('/create', function () { return view('lab.create'); })->name('create')->middleware('permission:lab.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:lab.create');
    Route::get('/{id}', function ($id) { return view('lab.show', ['id' => $id]); })->name('show')->middleware('permission:lab.view');
    Route::get('/{id}/edit', function ($id) { return view('lab.edit', ['id' => $id]); })->name('edit')->middleware('permission:lab.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:lab.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:lab.delete');
    Route::get('/{id}/print', function ($id) { return view('lab.print', ['id' => $id]); })->name('print')->middleware('permission:lab.print');
});


//====================================================
// CANTEEN MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:canteen'])->prefix('canteen')->name('canteen.')->group(function () {
    Route::get('/', function () { return view('canteen.index'); })->name('index')->middleware('permission:canteen.view');
    Route::get('/create', function () { return view('canteen.create'); })->name('create')->middleware('permission:canteen.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:canteen.create');
    Route::get('/{id}', function ($id) { return view('canteen.show', ['id' => $id]); })->name('show')->middleware('permission:canteen.view');
    Route::get('/{id}/edit', function ($id) { return view('canteen.edit', ['id' => $id]); })->name('edit')->middleware('permission:canteen.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:canteen.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:canteen.delete');
});


//====================================================
// MIS REPORT MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:mis-report'])->prefix('mis-report')->name('mis-report.')->group(function () {
    Route::get('/', function () { return view('mis-report.index'); })->name('index')->middleware('permission:mis-report.view');
    Route::get('/{id}', function ($id) { return view('mis-report.show', ['id' => $id]); })->name('show')->middleware('permission:mis-report.view');
    Route::get('/export', function () { /* Export logic */ })->name('export')->middleware('permission:mis-report.export');
});


//====================================================
// ACCOUNTS MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:accounts'])->prefix('accounts')->name('accounts.')->group(function () {
    Route::get('/', function () { return view('accounts.index'); })->name('index')->middleware('permission:accounts.view');
    Route::get('/create', function () { return view('accounts.create'); })->name('create')->middleware('permission:accounts.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:accounts.create');
    Route::get('/{id}', function ($id) { return view('accounts.show', ['id' => $id]); })->name('show')->middleware('permission:accounts.view');
    Route::get('/{id}/edit', function ($id) { return view('accounts.edit', ['id' => $id]); })->name('edit')->middleware('permission:accounts.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:accounts.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:accounts.delete');
    Route::get('/{id}/approve', function ($id) { /* Approve logic */ })->name('approve')->middleware('permission:accounts.approve');
    Route::get('/{id}/print', function ($id) { return view('accounts.print', ['id' => $id]); })->name('print')->middleware('permission:accounts.print');
});


//====================================================
// STORE MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:store'])->prefix('store')->name('store.')->group(function () {
    Route::get('/', function () { return view('store.index'); })->name('index')->middleware('permission:store.view');
    Route::get('/create', function () { return view('store.create'); })->name('create')->middleware('permission:store.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:store.create');
    Route::get('/{id}', function ($id) { return view('store.show', ['id' => $id]); })->name('show')->middleware('permission:store.view');
    Route::get('/{id}/edit', function ($id) { return view('store.edit', ['id' => $id]); })->name('edit')->middleware('permission:store.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:store.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:store.delete');
});


//====================================================
// INVENTORY MODULE ROUTES
//====================================================
Route::middleware(['auth', 'module:inventory'])->prefix('inventory')->name('inventory.')->group(function () {
    Route::get('/', function () { return view('inventory.index'); })->name('index')->middleware('permission:inventory.view');
    Route::get('/create', function () { return view('inventory.create'); })->name('create')->middleware('permission:inventory.create');
    Route::post('/', function () { /* Store logic */ })->name('store')->middleware('permission:inventory.create');
    Route::get('/{id}', function ($id) { return view('inventory.show', ['id' => $id]); })->name('show')->middleware('permission:inventory.view');
    Route::get('/{id}/edit', function ($id) { return view('inventory.edit', ['id' => $id]); })->name('edit')->middleware('permission:inventory.edit');
    Route::put('/{id}', function ($id) { /* Update logic */ })->name('update')->middleware('permission:inventory.edit');
    Route::delete('/{id}', function ($id) { /* Delete logic */ })->name('destroy')->middleware('permission:inventory.delete');
    Route::get('/export', function () { /* Export logic */ })->name('export')->middleware('permission:inventory.export');
});


require __DIR__ . '/auth.php';