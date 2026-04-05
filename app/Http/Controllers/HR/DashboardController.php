<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\TimeRecord;
use App\Models\Department;
use App\Models\Position;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Card statistics
        $activeEmployees = Employee::where('status', 'active')->count();
        $totalDepartments = Department::count();
        $totalPositions = Position::count();

        // Today's attendance
        $today = Carbon::today();
        $todayAttendance = TimeRecord::whereDate('work_date', $today)
            ->whereNotNull('check_in_time')
            ->count();

        // This week's attendance summary
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $weeklyAttendance = [];
        $days = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
        $currentDate = Carbon::now()->copy()->startOfWeek();

        for ($i = 0; $i < 7; $i++) {
            $date = $currentDate->copy()->addDays($i);
            $count = TimeRecord::whereDate('work_date', $date)
                ->whereNotNull('check_in_time')
                ->count();
            $weeklyAttendance[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $days[$i],
                'count' => $count,
                'is_today' => $date->isToday()
            ];
        }

        // Recent employees (last 5 added)
        $recentEmployees = Employee::with(['department', 'position'])
            ->latest()
            ->take(5)
            ->get();

        // Departments overview with employee counts
        $departments = Department::withCount('employees')
            ->orderBy('employees_count', 'desc')
            ->get();

        // Gender distribution
        $maleCount = Employee::where('status', 'active')->where('gender', 'male')->count();
        $femaleCount = Employee::where('status', 'active')->where('gender', 'female')->count();

        return view('hr.dashboard', compact(
            'activeEmployees',
            'todayAttendance',
            'totalDepartments',
            'totalPositions',
            'weeklyAttendance',
            'recentEmployees',
            'departments',
            'maleCount',
            'femaleCount'
        ));
    }
}
