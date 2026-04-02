<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\HR\DepartmentController;
use App\Http\Controllers\HR\PositionController;
use App\Http\Controllers\HR\TimeRecordController;
use App\Http\Controllers\Inventory\ItemController;
use App\Http\Controllers\Inventory\DashboardController;

// 1. ถ้ามีคนพิมพ์หน้าแรก (/) ให้ Redirect ไปที่ /login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. แสดงหน้าฟอร์ม Login (รองรับการพิมพ์ /login แบบ GET)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// 3. รับข้อมูลตอนกดปุ่มเข้าสู่ระบบ (แบบ POST)
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
        // ระบบจัดการพนักงาน (Employees)
        Route::resource('employees', EmployeeController::class);
        // ระบบจัดการแผนก (Departments) เผื่อไว้สำหรับทำระบบ Workflow ส่งต่องานในอนาคต
        Route::resource('departments', DepartmentController::class);
        // ระบบจัดการตำแหน่งงาน (Positions) เผื่อไว้สำหรับทำระบบ Workflow ส่งต่องานในอนาคต
        Route::resource('positions', PositionController::class);

        // ระบบบันทึกเวลาทำงาน (Time Records)
        Route::get('/time-records/batch', [TimeRecordController::class, 'batchCreate'])->name('time-records.batch');
        Route::post('/time-records/batch', [TimeRecordController::class, 'batchStore'])->name('time-records.batch.store');
        // รายงานสรุปเวลาทำงานรายเดือน
        Route::get('/time-records/batch-select', [TimeRecordController::class, 'batchSelect'])->name('time-records.batch.select');
        Route::get('/time-records/batch-form', [TimeRecordController::class, 'batchForm'])->name('time-records.batch.form');
        Route::post('/time-records/batch-store', [TimeRecordController::class, 'batchStore'])->name('time-records.batch.store');
        Route::get('/time-records/summary', [TimeRecordController::class, 'summary'])->name('time-records.summary');
        // ระบบปิดงวดเวลา (Lock Period)
        Route::get('/time-records/lock', [TimeRecordController::class, 'lockPeriod'])->name('time-records.lock');
        Route::post('/time-records/lock', [TimeRecordController::class, 'lockPeriodStore'])->name('time-records.lock.store');
    });

    // ==============================
    // โซนคลังสินค้า (Module 3 - Admin และ Inventory)
    // ==============================
    Route::middleware('role:admin,inventory')->prefix('inventory')->name('inventory.')->group(function () {

        // 🌟 เรียกใช้ DashboardController เพื่อให้มันประมวลผลข้อมูลก่อนโชว์หน้าจอ
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ระบบจัดการสินค้า (Items)
        Route::resource('items', ItemController::class);
    });

});