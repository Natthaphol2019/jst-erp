<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Requisition;
use App\Models\TimeRecord;
use App\Models\Employee as EmployeeModel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $employee = $user->employee;

        if (!$employee) {
            return view('employee.dashboard', [
                'myBorrowings' => collect(),
                'myRequisitions' => collect(),
                'activeBorrowingsCount' => 0,
                'pendingRequestsCount' => 0,
                'totalBorrowings' => 0,
                'totalRequisitions' => 0,
                'overdueBorrowings' => collect(),
                'recentNotifications' => collect(),
                'attendanceThisMonth' => 0,
                'recentAttendance' => collect(),
            ]);
        }

        // My active borrowings
        $myBorrowings = Requisition::with(['items.item'])
            ->where('employee_id', $employee->id)
            ->where('req_type', 'borrow')
            ->whereIn('status', ['approved', 'returned_partial'])
            ->latest()
            ->take(5)
            ->get();

        $activeBorrowingsCount = $myBorrowings->count();

        // My pending requests
        $myPendingRequests = Requisition::with(['items.item'])
            ->where('employee_id', $employee->id)
            ->where('req_type', 'consumption')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $pendingRequestsCount = $myPendingRequests->count();

        // My requisitions (all)
        $myRequisitions = Requisition::with(['approver'])
            ->where('employee_id', $employee->id)
            ->whereIn('req_type', ['consumption', 'borrow'])
            ->latest()
            ->take(10)
            ->get();

        // Total borrowings count
        $totalBorrowings = Requisition::where('employee_id', $employee->id)
            ->where('req_type', 'borrow')
            ->count();

        // Total requisitions count
        $totalRequisitions = Requisition::where('employee_id', $employee->id)
            ->where('req_type', 'consumption')
            ->count();

        // Overdue borrowings
        $overdueBorrowings = Requisition::with(['items.item'])
            ->where('employee_id', $employee->id)
            ->where('req_type', 'borrow')
            ->whereIn('status', ['approved', 'returned_partial'])
            ->where('due_date', '<', Carbon::today())
            ->latest()
            ->get();

        // Recent notifications
        $recentNotifications = $user->notifications()->latest()->take(10)->get();

        // Attendance this month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $attendanceThisMonth = TimeRecord::where('employee_id', $employee->id)
            ->whereBetween('work_date', [$startOfMonth, $endOfMonth])
            ->whereNotNull('check_in_time')
            ->count();

        // Recent attendance records
        $recentAttendance = TimeRecord::where('employee_id', $employee->id)
            ->whereNotNull('check_in_time')
            ->latest()
            ->take(10)
            ->get();

        return view('employee.dashboard', compact(
            'myBorrowings',
            'myRequisitions',
            'myPendingRequests',
            'activeBorrowingsCount',
            'pendingRequestsCount',
            'totalBorrowings',
            'totalRequisitions',
            'overdueBorrowings',
            'recentNotifications',
            'attendanceThisMonth',
            'recentAttendance'
        ));
    }
}
