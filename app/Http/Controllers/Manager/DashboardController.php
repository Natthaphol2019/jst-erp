<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Requisition;
use App\Models\TimeRecord;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Card statistics
        $totalEmployees = Employee::where('status', 'active')->count();
        $totalDepartments = Department::count();
        $pendingApprovals = Requisition::where('status', 'pending')->count();

        // Department statistics
        $departments = Department::withCount(['employees' => function ($query) {
            $query->where('status', 'active');
        }])->get();

        // Recent activity (recent requisitions)
        $recentActivity = Requisition::with(['employee', 'approver'])
            ->latest()
            ->take(10)
            ->get();

        // This week's attendance
        $today = Carbon::today();
        $todayAttendance = TimeRecord::whereDate('work_date', $today)
            ->whereNotNull('check_in_time')
            ->count();

        // Active borrowings
        $activeBorrowings = Requisition::where('req_type', 'borrow')
            ->whereIn('status', ['approved', 'returned_partial'])
            ->count();

        // Requisitions by status
        $pendingCount = Requisition::where('status', 'pending')->count();
        $approvedCount = Requisition::where('status', 'approved')->count();
        $completedCount = Requisition::where('status', 'returned_all')->count();

        return view('manager.dashboard', compact(
            'totalEmployees',
            'totalDepartments',
            'pendingApprovals',
            'departments',
            'recentActivity',
            'todayAttendance',
            'activeBorrowings',
            'pendingCount',
            'approvedCount',
            'completedCount'
        ));
    }
}
