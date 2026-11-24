
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

// Root URL
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ADMIN ONLY ROUTES
Route::middleware(['auth', 'role:Admin'])->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [EmployeeController::class, 'index'])
        ->name('dashboard');

    // Employee Status
    Route::patch('/employees/{employee}/toggle-status',
        [EmployeeController::class, 'toggleStatus']
    )->name('employees.toggleStatus');

    // Export
    Route::get('/employees-export', [EmployeeController::class, 'export'])
        ->name('employees.export');

    // Import
    Route::post('/employees-import', [EmployeeController::class, 'import'])
        ->name('employees.import');

    // Trash
    Route::get('/employees-trash', [EmployeeController::class, 'trash'])
        ->name('employees.trash');

    Route::patch('/employees/{id}/restore',
        [EmployeeController::class, 'restore']
    )->name('employees.restore');

    Route::delete('/employees/{id}/force-delete',
        [EmployeeController::class, 'forceDelete']
    )->name('employees.forceDelete');

    // Employee CRUD
    Route::resource('employees', EmployeeController::class);
});

// EMPLOYEE ONLY ROUTES
Route::middleware(['auth', 'role:Employee'])->group(function () {

    Route::get('/employee/dashboard', function () {
        return view('employee.dashboard');
    })->name('employee.dashboard');
    Route::get('/employee/profile/edit',
    [\App\Http\Controllers\EmployeeProfileController::class, 'edit']
)->name('employee.profile.edit');
Route::put('/employee/profile/update',
    [\App\Http\Controllers\EmployeeProfileController::class, 'update']
)->name('employee.profile.update');

});
