<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Requisition;
use App\Models\TimeRecord;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Card statistics
        $totalEmployees = Employee::where('status', 'active')->count();
        $totalItems = Item::count();
        $pendingRequisitions = Requisition::where('status', 'pending')->count();
        $overdueBorrowings = Requisition::where('req_type', 'borrow')
            ->whereIn('status', ['approved', 'returned_partial'])
            ->where('due_date', '<', Carbon::today())
            ->count();

        // Recent requisitions (last 10)
        $recentRequisitions = Requisition::with(['employee', 'approver'])
            ->latest()
            ->take(10)
            ->get();

        // Low stock items
        $lowStockItems = Item::whereColumn('current_stock', '<=', 'min_stock')
            ->where('status', 'available')
            ->with('category')
            ->get();

        // Today's attendance
        $today = Carbon::today();
        $todayAttendance = TimeRecord::whereDate('work_date', $today)
            ->where('check_in_time', '!=', null)
            ->count();

        // Department count
        $departmentCount = Department::count();

        // User count
        $totalUsers = User::count();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'totalItems',
            'pendingRequisitions',
            'overdueBorrowings',
            'recentRequisitions',
            'lowStockItems',
            'todayAttendance',
            'departmentCount',
            'totalUsers'
        ));
    }
}
