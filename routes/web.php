<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// หน้า Login ทั่วไป
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==============================
// โซนที่ต้อง Login ก่อนเท่านั้น
// ==============================
Route::middleware('auth')->group(function () {

    // Dashboard กลาง (fallback)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ==============================
    // โซน Admin
    // ==============================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });

    // ==============================
    // โซน Manager
    // ==============================
    Route::middleware('role:manager')->prefix('manager')->name('manager.')->group(function () {
        Route::get('/dashboard', function () {
            return view('manager.dashboard');
        })->name('dashboard');
    });

    // ==============================
    // โซน Employee
    // ==============================
    Route::middleware('role:employee')->prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', function () {
            return view('employee.dashboard');
        })->name('dashboard');
    });

    // ==============================
    // โซน Admin และ HR (Module 1)
    // ==============================
    Route::middleware('role:admin,hr')->prefix('hr')->name('hr.')->group(function () {
        Route::get('/dashboard', function () {
            return 'หน้า Dashboard จัดการพนักงาน (HR/Admin)';
        });
        // Route::resource('employees', EmployeeController::class);
    });

    // ==============================
    // โซนคลังสินค้า (Module 3 - Admin และ Inventory)
    // ==============================
    Route::middleware('role:admin,inventory')->prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/dashboard', function () {
            return 'หน้า Dashboard จัดการคลังสินค้า (Inventory/Admin)';
        });
        // Route::resource('items', ItemController::class);
    });

});