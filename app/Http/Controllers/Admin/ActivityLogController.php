<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with(['user', 'subject']);

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by log name
        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        // Filter by subject type
        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->subject_type);
        }

        // Filter by action type (created, updated, deleted)
        if ($request->filled('action_type')) {
            $actionKeyword = match ($request->action_type) {
                'created' => 'สร้าง',
                'updated' => 'แก้ไข',
                'deleted' => 'ลบ',
                default => null,
            };
            if ($actionKeyword) {
                $query->where('description', 'like', '%' . $actionKeyword . '%');
            }
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $activityLogs = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        // Get available users for filter
        $users = User::orderBy('name')->get();

        // Get available subject types
        $subjectTypes = ActivityLog::whereNotNull('subject_type')
            ->distinct()
            ->pluck('subject_type')
            ->map(function ($class) {
                return [
                    'class' => $class,
                    'name' => class_basename($class),
                    'thai_name' => $this->getThaiSubjectName($class),
                ];
            });

        // Get log names for filter
        $logNames = ActivityLog::distinct()->pluck('log_name');

        return view('admin.activity_logs.index', compact(
            'activityLogs',
            'users',
            'subjectTypes',
            'logNames'
        ));
    }

    /**
     * Display the specified activity log.
     */
    public function show($id)
    {
        $activityLog = ActivityLog::with(['user', 'subject'])->findOrFail($id);

        // Get related logs for the same subject
        $relatedLogs = ActivityLog::where('subject_type', $activityLog->subject_type)
            ->where('subject_id', $activityLog->subject_id)
            ->where('id', '!=', $activityLog->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.activity_logs.show', compact('activityLog', 'relatedLogs'));
    }

    /**
     * Display activity logs for a specific subject.
     */
    public function forSubject($type, $id)
    {
        // Convert type to full class name if short name provided
        $fullClass = $this->resolveSubjectType($type);

        $query = ActivityLog::with(['user', 'subject'])
            ->where('subject_type', $fullClass)
            ->where('subject_id', $id);

        $activityLogs = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get the subject model for display
        $subject = null;
        if (class_exists($fullClass)) {
            $subject = $fullClass::find($id);
        }

        $subjectTypeName = $subject ? $this->getThaiSubjectName(get_class($subject)) : $type;

        return view('admin.activity_logs.index', compact(
            'activityLogs',
            'subject',
            'subjectTypeName'
        ));
    }

    /**
     * Resolve a short subject type to full class name.
     */
    protected function resolveSubjectType(string $type): string
    {
        // If it's already a full class name, return it
        if (class_exists($type)) {
            return $type;
        }

        // Map short names to full class names
        $mapping = [
            'employee' => 'App\\Models\\Employee',
            'department' => 'App\\Models\\Department',
            'position' => 'App\\Models\\Position',
            'item' => 'App\\Models\\Item',
            'itemcategory' => 'App\\Models\\ItemCategory',
            'requisition' => 'App\\Models\\Requisition',
            'requisitionitem' => 'App\\Models\\RequisitionItem',
        ];

        $lowerType = strtolower(str_replace(' ', '', $type));

        return $mapping[$lowerType] ?? 'App\\Models\\' . ucfirst($type);
    }

    /**
     * Get Thai name for subject type.
     */
    protected function getThaiSubjectName(string $class): string
    {
        return match (class_basename($class)) {
            'Employee' => 'พนักงาน',
            'Department' => 'แผนก',
            'Position' => 'ตำแหน่ง',
            'Item' => 'สินค้า',
            'ItemCategory' => 'หมวดหมู่สินค้า',
            'Requisition' => 'ใบเบิก',
            'RequisitionItem' => 'รายการเบิก',
            default => class_basename($class),
        };
    }
}
