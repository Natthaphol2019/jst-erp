<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Requisition;
use App\Models\Department;
use App\Models\Position;

class SearchController extends Controller
{
    /**
     * Global search across all entities.
     * Returns JSON with results grouped by type.
     */
    public function index(Request $request)
    {
        $query = $request->input('q', '');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([
                'employees' => [],
                'items' => [],
                'requisitions' => [],
                'departments' => [],
                'positions' => [],
            ]);
        }

        $limit = 10;

        return response()->json([
            'employees' => $this->searchEmployees($query, $limit),
            'items' => $this->searchItems($query, $limit),
            'requisitions' => $this->searchRequisitions($query, $limit),
            'departments' => $this->searchDepartments($query, $limit),
            'positions' => $this->searchPositions($query, $limit),
        ]);
    }

    /**
     * Search employees by name or employee_code.
     */
    protected function searchEmployees(string $query, int $limit): array
    {
        $results = Employee::with(['department', 'position'])
            ->where(function ($q) use ($query) {
                $q->where('firstname', 'like', "%{$query}%")
                  ->orWhere('lastname', 'like', "%{$query}%")
                  ->orWhere('employee_code', 'like', "%{$query}%");
            })
            ->limit($limit)
            ->get();

        return $results->map(function ($employee) {
            $name = trim($employee->prefix . ' ' . $employee->firstname . ' ' . $employee->lastname);
            return [
                'id' => $employee->id,
                'title' => $name,
                'subtitle' => $employee->employee_code . ($employee->department ? ' - ' . $employee->department->name : ''),
                'icon' => 'bi-person-badge',
                'color' => 'primary',
                'route' => route('hr.employees.edit', $employee->id),
            ];
        })->toArray();
    }

    /**
     * Search items by name or item_code.
     */
    protected function searchItems(string $query, int $limit): array
    {
        $results = Item::with('category')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('item_code', 'like', "%{$query}%");
            })
            ->limit($limit)
            ->get();

        return $results->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->name,
                'subtitle' => $item->item_code . ' (Stock: ' . number_format($item->current_stock) . ' ' . $item->unit . ')',
                'icon' => 'bi-box-seam',
                'color' => 'success',
                'route' => route('inventory.items.edit', $item->id),
            ];
        })->toArray();
    }

    /**
     * Search requisitions by id or note.
     */
    protected function searchRequisitions(string $query, int $limit): array
    {
        $results = Requisition::with('employee')
            ->where(function ($q) use ($query) {
                $q->where('id', 'like', "%{$query}%")
                  ->orWhere('note', 'like', "%{$query}%");
            })
            ->limit($limit)
            ->get();

        return $results->map(function ($req) {
            $title = 'REQ#' . $req->id;
            $subtitle = $req->note ?: 'No note';
            if ($req->employee) {
                $subtitle .= ' - ' . $req->employee->firstname;
            }
            return [
                'id' => $req->id,
                'title' => $title,
                'subtitle' => $subtitle . ' (' . $req->req_date . ')',
                'icon' => 'bi-file-earmark-text',
                'color' => 'warning',
                'route' => route('inventory.requisition.show', $req->id),
            ];
        })->toArray();
    }

    /**
     * Search departments by name.
     */
    protected function searchDepartments(string $query, int $limit): array
    {
        $results = Department::where('name', 'like', "%{$query}%")
            ->limit($limit)
            ->get();

        return $results->map(function ($dept) {
            return [
                'id' => $dept->id,
                'title' => $dept->name,
                'subtitle' => $dept->description ?: '',
                'icon' => 'bi-building',
                'color' => 'info',
                'route' => route('hr.departments.edit', $dept->id),
            ];
        })->toArray();
    }

    /**
     * Search positions by name.
     */
    protected function searchPositions(string $query, int $limit): array
    {
        $results = Position::with('department')
            ->where('name', 'like', "%{$query}%")
            ->limit($limit)
            ->get();

        return $results->map(function ($position) {
            return [
                'id' => $position->id,
                'title' => $position->name,
                'subtitle' => $position->department ? $position->department->name : '',
                'icon' => 'bi-briefcase',
                'color' => 'secondary',
                'route' => route('hr.positions.edit', $position->id),
            ];
        })->toArray();
    }
}
