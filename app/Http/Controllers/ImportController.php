<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class ImportController extends Controller
{
    /**
     * Show import form for employees.
     */
    public function showEmployeeImportForm()
    {
        return view('imports.employees');
    }

    /**
     * Show import form for items.
     */
    public function showItemImportForm()
    {
        return view('imports.items');
    }

    /**
     * Import employees from uploaded file.
     */
    public function importEmployees(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:5120',
        ]);

        $file = $request->file('file');

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
        } catch (\Exception $e) {
            return back()->with('error', 'ไม่สามารถอ่านไฟล์ได้: ' . $e->getMessage());
        }

        if (count($rows) < 2) {
            return back()->with('error', 'ไฟล์ไม่มีข้อมูล กรุณาใส่ข้อมูลอย่างน้อย 1 แถว');
        }

        // First row is header - validate
        $header = array_map('trim', $rows[0]);
        $requiredColumns = ['employee_code', 'firstname', 'lastname'];

        $missingColumns = array_diff($requiredColumns, $header);
        if (!empty($missingColumns)) {
            return back()->with('error', 'คอลัมน์ที่ขาดหาย: ' . implode(', ', $missingColumns));
        }

        $results = ['success' => 0, 'failed' => 0, 'errors' => []];

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];

            // Skip empty rows
            if (empty(array_filter($row, fn($v) => trim($v) !== ''))) {
                continue;
            }

            $data = array_combine($header, $row);
            $rowNum = $i + 1;

            $validator = Validator::make($data, [
                'employee_code' => 'required|string|max:50',
                'prefix' => 'nullable|string|in:นาย,นาง,นางสาว',
                'firstname' => 'required|string|max:100',
                'lastname' => 'required|string|max:100',
                'gender' => 'nullable|string|in:male,female,other',
                'department_name' => 'nullable|string|max:100',
                'position_name' => 'nullable|string|max:100',
                'start_date' => 'nullable|date',
                'status' => 'nullable|string|in:active,inactive,resigned',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                $results['failed']++;
                $results['errors'][] = [
                    'row' => $rowNum,
                    'employee_code' => $data['employee_code'] ?? '-',
                    'errors' => $validator->errors()->all(),
                ];
                continue;
            }

            // Resolve department
            $departmentId = null;
            if (!empty($data['department_name'])) {
                $dept = Department::where('name', trim($data['department_name']))->first();
                if ($dept) {
                    $departmentId = $dept->id;
                }
            }

            // Resolve position
            $positionId = null;
            if (!empty($data['position_name'])) {
                $pos = Position::where('name', trim($data['position_name']))->first();
                if ($pos) {
                    $positionId = $pos->id;
                }
            }

            // Parse date
            $startDate = null;
            if (!empty($data['start_date'])) {
                try {
                    $startDate = Carbon::parse(trim($data['start_date']))->format('Y-m-d');
                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][] = [
                        'row' => $rowNum,
                        'employee_code' => $data['employee_code'],
                        'errors' => ['วันที่เริ่มงานไม่ถูกต้อง'],
                    ];
                    continue;
                }
            }

            // Check if employee exists by code
            $employee = Employee::where('employee_code', trim($data['employee_code']))->first();

            if ($employee) {
                // Update existing
                $employee->update([
                    'prefix' => $data['prefix'] ?? $employee->prefix,
                    'firstname' => trim($data['firstname']),
                    'lastname' => trim($data['lastname']),
                    'gender' => $data['gender'] ?? $employee->gender,
                    'department_id' => $departmentId ?? $employee->department_id,
                    'position_id' => $positionId ?? $employee->position_id,
                    'start_date' => $startDate ?? $employee->start_date,
                    'status' => $data['status'] ?? $employee->status,
                    'phone' => $data['phone'] ?? $employee->phone,
                    'address' => $data['address'] ?? $employee->address,
                ]);
            } else {
                // Create new
                Employee::create([
                    'employee_code' => trim($data['employee_code']),
                    'prefix' => $data['prefix'] ?? null,
                    'firstname' => trim($data['firstname']),
                    'lastname' => trim($data['lastname']),
                    'gender' => $data['gender'] ?? 'other',
                    'department_id' => $departmentId,
                    'position_id' => $positionId,
                    'start_date' => $startDate,
                    'status' => $data['status'] ?? 'active',
                    'phone' => $data['phone'] ?? null,
                    'address' => $data['address'] ?? null,
                ]);
            }

            $results['success']++;
        }

        return back()->with('import_results', $results);
    }

    /**
     * Import items from uploaded file.
     */
    public function importItems(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:5120',
        ]);

        $file = $request->file('file');

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
        } catch (\Exception $e) {
            return back()->with('error', 'ไม่สามารถอ่านไฟล์ได้: ' . $e->getMessage());
        }

        if (count($rows) < 2) {
            return back()->with('error', 'ไฟล์ไม่มีข้อมูล กรุณาใส่ข้อมูลอย่างน้อย 1 แถว');
        }

        // First row is header - validate
        $header = array_map('trim', $rows[0]);
        $requiredColumns = ['item_code', 'name'];

        $missingColumns = array_diff($requiredColumns, $header);
        if (!empty($missingColumns)) {
            return back()->with('error', 'คอลัมน์ที่ขาดหาย: ' . implode(', ', $missingColumns));
        }

        $results = ['success' => 0, 'failed' => 0, 'errors' => []];

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];

            // Skip empty rows
            if (empty(array_filter($row, fn($v) => trim($v) !== ''))) {
                continue;
            }

            $data = array_combine($header, $row);
            $rowNum = $i + 1;

            $validator = Validator::make($data, [
                'item_code' => 'required|string|max:50',
                'name' => 'required|string|max:255',
                'category_name' => 'nullable|string|max:100',
                'type' => 'nullable|string|in:equipment,consumable,other',
                'unit' => 'nullable|string|max:50',
                'current_stock' => 'nullable|integer|min:0',
                'min_stock' => 'nullable|integer|min:0',
                'location' => 'nullable|string|max:255',
                'status' => 'nullable|string|in:available,unavailable,maintenance',
            ]);

            if ($validator->fails()) {
                $results['failed']++;
                $results['errors'][] = [
                    'row' => $rowNum,
                    'item_code' => $data['item_code'] ?? '-',
                    'errors' => $validator->errors()->all(),
                ];
                continue;
            }

            // Resolve category
            $categoryId = null;
            if (!empty($data['category_name'])) {
                $cat = ItemCategory::where('name', trim($data['category_name']))->first();
                if ($cat) {
                    $categoryId = $cat->id;
                }
            }

            // Check if item exists by code
            $item = Item::where('item_code', trim($data['item_code']))->first();

            $itemData = [
                'name' => trim($data['name']),
                'category_id' => $categoryId,
                'type' => $data['type'] ?? 'equipment',
                'unit' => $data['unit'] ?? 'piece',
                'current_stock' => (int) ($data['current_stock'] ?? 0),
                'min_stock' => (int) ($data['min_stock'] ?? 0),
                'location' => $data['location'] ?? null,
                'status' => $data['status'] ?? 'available',
            ];

            if ($item) {
                $item->update($itemData);
            } else {
                $itemData['item_code'] = trim($data['item_code']);
                Item::create($itemData);
            }

            $results['success']++;
        }

        return back()->with('import_results', $results);
    }

    /**
     * Download sample CSV template for employees.
     */
    public function downloadEmployeeTemplate()
    {
        $filename = 'employee_import_template.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel to properly display Thai characters
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'employee_code',
                'prefix',
                'firstname',
                'lastname',
                'gender',
                'department_name',
                'position_name',
                'start_date',
                'status',
                'phone',
                'address',
            ]);

            // Sample data
            fputcsv($file, [
                'EMP001',
                'นาย',
                'สมชาย',
                'ใจดี',
                'male',
                'ฝ่ายผลิต',
                'พนักงานผลิต',
                '2025-01-15',
                'active',
                '0812345678',
                '123 ถ.สุขุมวิท กรุงเทพฯ',
            ]);

            fputcsv($file, [
                'EMP002',
                'นางสาว',
                'สมหญิง',
                'รักงาน',
                'female',
                'ฝ่ายบุคคล',
                'เจ้าหน้าที่บุคคล',
                '2025-02-01',
                'active',
                '0898765432',
                '',
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download sample CSV template for items.
     */
    public function downloadItemTemplate()
    {
        $filename = 'item_import_template.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'item_code',
                'name',
                'category_name',
                'type',
                'unit',
                'current_stock',
                'min_stock',
                'location',
                'status',
            ]);

            // Sample data
            fputcsv($file, [
                'ITM001',
                'สว่านไฟฟ้า',
                'เครื่องมือช่าง',
                'equipment',
                'ชิ้น',
                '10',
                '2',
                'คลัง A ชั้น 1',
                'available',
            ]);

            fputcsv($file, [
                'ITM002',
                'กระดาษทราย',
                'วัสดุสิ้นเปลือง',
                'consumable',
                'แผ่น',
                '100',
                '20',
                'คลัง B',
                'available',
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
