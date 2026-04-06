<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HealthCheckController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HR\DashboardController as HRDashboardController;
use App\Http\Controllers\HR\DepartmentController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\HR\PositionController;
use App\Http\Controllers\HR\TimeRecordController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Inventory\BarcodeController;
use App\Http\Controllers\Inventory\BorrowingController;
use App\Http\Controllers\Inventory\DashboardController as InventoryDashboardController;
use App\Http\Controllers\Inventory\ItemCategoryController;
use App\Http\Controllers\Inventory\ItemController;
use App\Http\Controllers\Inventory\RequisitionController;
use App\Http\Controllers\Inventory\StockTransactionController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

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
    // Global Search
    // ==============================
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // ==============================
    // Barcode / QR Code
    // ==============================
    Route::prefix('items')->name('inventory.items.')->group(function () {
        Route::get('/{item}/barcode', [BarcodeController::class, 'generateBarcode'])->name('barcode');
        Route::get('/{item}/qrcode', [BarcodeController::class, 'generateQrCode'])->name('qrcode');
        Route::get('/{item}/print-barcode', [BarcodeController::class, 'printBarcode'])->name('print-barcode');
    });

    // ==============================
    // จัดการโปรไฟล์ตัวเอง (All authenticated users)
    // ==============================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    });

    // ==============================
    // การแจ้งเตือน (All authenticated users)
    // ==============================
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
    });

    // ==============================
    // Export Routes
    // ==============================
    Route::prefix('exports')->name('exports.')->group(function () {
        Route::get('/employees', [ExportController::class, 'exportEmployees'])->name('employees');
        Route::get('/items', [ExportController::class, 'exportItems'])->name('items');
        Route::get('/borrowings', [ExportController::class, 'exportBorrowings'])->name('borrowings');
        Route::get('/requisitions', [ExportController::class, 'exportRequisitions'])->name('requisitions');
        Route::get('/stock-transactions', [ExportController::class, 'exportStockTransactions'])->name('stock-transactions');
        Route::get('/time-records', [ExportController::class, 'exportTimeRecords'])->name('time-records');
    });

    // ==============================
    // โซน Admin
    // ==============================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('/activity-logs/{id}', [ActivityLogController::class, 'show'])->name('activity-logs.show');

        // ==============================
        // ระบบนําเข้าข้อมูล (Import)
        // ==============================
        Route::prefix('imports')->name('imports.')->group(function () {
            Route::get('/employees', [ImportController::class, 'showEmployeeImportForm'])->name('employees.form');
            Route::post('/employees', [ImportController::class, 'importEmployees'])->name('employees.process');
            Route::get('/items', [ImportController::class, 'showItemImportForm'])->name('items.form');
            Route::post('/items', [ImportController::class, 'importItems'])->name('items.process');
            Route::get('/template/employees', [ImportController::class, 'downloadEmployeeTemplate'])->name('template.employees');
            Route::get('/template/items', [ImportController::class, 'downloadItemTemplate'])->name('template.items');
        });

        // ==============================
        // ระบบสํารองข้อมูล (Backup)
        // ==============================
        Route::prefix('backups')->name('backups.')->group(function () {
            Route::get('/', [BackupController::class, 'index'])->name('index');
            Route::post('/', [BackupController::class, 'create'])->name('create');
            Route::get('/{filename}/download', [BackupController::class, 'download'])->name('download');
            Route::delete('/{filename}', [BackupController::class, 'delete'])->name('delete');
            Route::post('/{filename}/restore', [BackupController::class, 'restore'])->name('restore');
        });

        // ==============================
        // ระบบตรวจสอบสุขภาพระบบ (Health Check)
        // ==============================
        Route::get('/health', [HealthCheckController::class, 'index'])->name('health');
    });

    // ==============================
    // โซน Manager
    // ==============================
    Route::middleware('role:manager')->prefix('manager')->name('manager.')->group(function () {
        Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');
    });

    // ==============================
    // โซน Employee
    // ==============================
    Route::middleware('role:employee')->prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');

        // Employee borrowing history (ดูเฉพาะของตัวเอง)
        Route::get('/borrowings', [BorrowingController::class, 'myBorrowings'])->name('borrowings');
        Route::get('/borrowings/create', [BorrowingController::class, 'createForEmployee'])->name('borrowing.create');
        Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowing.store');
        Route::get('/borrowings/{borrowing}', [BorrowingController::class, 'show'])->name('borrowing.show');

        // Employee requisition history (ดูเฉพาะของตัวเอง)
        Route::get('/requisitions', [RequisitionController::class, 'myRequisitions'])->name('requisitions');
        Route::get('/requisitions/create', [RequisitionController::class, 'create'])->name('requisition.create');
        Route::post('/requisitions', [RequisitionController::class, 'store'])->name('requisition.store');
        Route::get('/requisitions/{requisition}', [RequisitionController::class, 'show'])->name('requisition.show');
    });

    // ==============================
    // โซน Admin และ HR (Module 1)
    // ==============================
    Route::middleware('role:admin,hr')->prefix('hr')->name('hr.')->group(function () {
        Route::get('/dashboard', [HRDashboardController::class, 'index'])->name('dashboard');
        // ระบบจัดการพนักงาน (Employees)
        Route::resource('employees', EmployeeController::class);
        Route::patch('/employees/{employee}/toggle-block', [EmployeeController::class, 'toggleBlock'])->name('employees.toggle-block');
        // ระบบจัดการแผนก (Departments)
        Route::resource('departments', DepartmentController::class);
        // ระบบจัดการตำแหน่งงาน (Positions)
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
        Route::get('/time-records/logs', [TimeRecordController::class, 'viewLogs'])->name('time-records.logs');
    });

    // ==============================
    // โซนเบิกสินค้า (Employee — สร้าง/ดู/แก้ไข ของตัวเอง)
    // ==============================
    Route::middleware('auth')->prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/requisition/create', [RequisitionController::class, 'create'])->name('requisition.create');
        Route::post('/requisition', [RequisitionController::class, 'store'])->name('requisition.store');
        Route::get('/requisition/{requisition}', [RequisitionController::class, 'show'])->name('requisition.show');
        Route::get('/requisition/{requisition}/edit', [RequisitionController::class, 'edit'])->name('requisition.edit');
        Route::put('/requisition/{requisition}', [RequisitionController::class, 'update'])->name('requisition.update');
    });

    // ==============================
    // โซนคลังสินค้า (Module 3 - Admin และ Inventory)
    // ==============================
    Route::middleware('role:admin,inventory')->prefix('inventory')->name('inventory.')->group(function () {

        // 🌟 เรียกใช้ DashboardController เพื่อให้มันประมวลผลข้อมูลก่อนโชว์หน้าจอ
        Route::get('/dashboard', [InventoryDashboardController::class, 'index'])->name('dashboard');

        // ระบบจัดการสินค้า (Items)
        Route::resource('items', ItemController::class);
        Route::patch('/items/{item}/toggle-status', [ItemController::class, 'toggleStatus'])->name('items.toggle-status');

        // ระบบจัดการหมวดหมู่สินค้า (Item Categories)
        Route::resource('categories', ItemCategoryController::class);

        // ระบบยืม-คืนอุปกรณ์ (Borrowing System)
        Route::get('/borrowing', [BorrowingController::class, 'index'])->name('borrowing.index');
        Route::get('/borrowing/create', [BorrowingController::class, 'create'])->name('borrowing.create');
        Route::post('/borrowing', [BorrowingController::class, 'store'])->name('borrowing.store');
        Route::get('/borrowing/pdf', [BorrowingController::class, 'pdfList'])->name('borrowing.pdf-list');
        Route::get('/borrowing/{borrowing}', [BorrowingController::class, 'show'])->name('borrowing.show');
        Route::get('/borrowing/{borrowing}/pdf', [BorrowingController::class, 'pdf'])->name('borrowing.pdf');
        Route::get('/borrowing/{borrowing}/edit', [BorrowingController::class, 'edit'])->name('borrowing.edit');
        Route::put('/borrowing/{borrowing}', [BorrowingController::class, 'update'])->name('borrowing.update');
        Route::get('/borrowing/{borrowing}/return', [BorrowingController::class, 'returnForm'])->name('borrowing.return');
        Route::post('/borrowing/{borrowing}/return', [BorrowingController::class, 'returnStore'])->name('borrowing.return.store');

        // ระบบเบิกอุปทาน (Requisition/Consumption System)
        Route::get('/requisition', [RequisitionController::class, 'index'])->name('requisition.index');
        Route::get('/requisition/{requisition}/approve', [RequisitionController::class, 'approveForm'])->name('requisition.approve');
        Route::post('/requisition/{requisition}/approve', [RequisitionController::class, 'approve'])->name('requisition.approve.store');

        // ระบบรายงานคลังสินค้า (Stock Reports)
        Route::get('/transactions', [StockTransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{transaction}', [StockTransactionController::class, 'show'])->name('transactions.show');
        Route::get('/transactions/summary', [StockTransactionController::class, 'summary'])->name('transactions.summary');
        Route::get('/transactions/daily-report', [StockTransactionController::class, 'dailyReport'])->name('transactions.daily');
        Route::get('/transactions/category-report', [StockTransactionController::class, 'categoryReport'])->name('transactions.category');
    });

    // ==============================
    // ระบบอัปโหลดรูปภาพ
    // ==============================
    Route::prefix('uploads')->name('uploads.')->group(function () {
        // อัปโหลดรูปพนักงาน
        Route::post('/employees/{employee}/image', [ImageUploadController::class, 'uploadEmployeeImage'])->name('employee');
        Route::delete('/employees/{employee}/image', [ImageUploadController::class, 'deleteEmployeeImage'])->name('employee.delete');

        // อัปโหลดรูปสินค้า
        Route::post('/items/{item}/image', [ImageUploadController::class, 'uploadItemImage'])->name('item');
        Route::delete('/items/{item}/image', [ImageUploadController::class, 'deleteItemImage'])->name('item.delete');
    });

});
