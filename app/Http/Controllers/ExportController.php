<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Item;
use App\Models\Requisition;
use App\Models\StockTransaction;
use App\Models\TimeRecord;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * Apply common styling to a range
     */
    protected function styleRange($sheet, $range, $styles)
    {
        $sheet->getStyle($range)->applyFromArray($styles);
    }

    /**
     * Set header style
     */
    protected function setHeaderStyle($sheet, $row, $colCount)
    {
        $headerStyle = [
            'font' => ['bold' => true, 'size' => 12],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4A90D9'],
            ],
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $endCol = chr(65 + $colCount - 1);
        $sheet->getStyle("A{$row}:{$endCol}{$row}")->applyFromArray($headerStyle);
    }

    /**
     * Set border to range
     */
    protected function setBorder($sheet, $startRow, $endRow, $colCount)
    {
        $endCol = chr(65 + $colCount - 1);
        $sheet->getStyle("A{$startRow}:{$endCol}{$endRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
    }

    /**
     * Export all employees to Excel
     */
    public function exportEmployees()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Title
        $sheet->setCellValue('A1', 'รายงานข้อมูลพนักงาน');
        $sheet->setCellValue('A2', 'วันที่ส่งออก: ' . Carbon::now()->format('d/m/Y H:i:s'));
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setSize(10);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Headers
        $headers = ['รหัส', 'คานําหน้า', 'ชื่อ', 'นามสกุล', 'เพศ', 'แผนก', 'ตําแหน่ง', 'วันที่เริ่มงาน', 'สถานะ'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $col++;
        }

        $this->setHeaderStyle($sheet, 4, count($headers));

        // Data
        $employees = Employee::with(['department', 'position'])->orderBy('employee_code')->get();
        $row = 5;
        foreach ($employees as $emp) {
            $sheet->setCellValue('A' . $row, $emp->employee_code);
            $sheet->setCellValue('B' . $row, $emp->prefix);
            $sheet->setCellValue('C' . $row, $emp->firstname);
            $sheet->setCellValue('D' . $row, $emp->lastname);
            $sheet->setCellValue('E' . $row, match ($emp->gender) {
                'male' => 'ชาย',
                'female' => 'หญิง',
                default => $emp->gender ?? '-'
            });
            $sheet->setCellValue('F' . $row, $emp->department->name ?? '-');
            $sheet->setCellValue('G' . $row, $emp->position->name ?? '-');
            $sheet->setCellValue('H' . $row, $emp->start_date ? Carbon::parse($emp->start_date)->format('d/m/Y') : '-');
            $sheet->setCellValue('I' . $row, match ($emp->status) {
                'active' => 'ทํางานอยู่',
                'inactive' => 'พักงาน',
                'resigned' => 'ลาออก',
                default => $emp->status
            });
            $row++;
        }

        // Summary row
        $sheet->setCellValue('A' . $row, 'รวมทั้งหมด');
        $sheet->setCellValue('B' . $row, $employees->count() . ' คน');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);

        $this->setBorder($sheet, 4, $row, count($headers));

        $filename = 'employees_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';
        return $this->downloadSpreadsheet($spreadsheet, $filename);
    }

    /**
     * Export all items to Excel
     */
    public function exportItems()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Title
        $sheet->setCellValue('A1', 'รายงานข้อมูลสินค้า');
        $sheet->setCellValue('A2', 'วันที่ส่งออก: ' . Carbon::now()->format('d/m/Y H:i:s'));
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setSize(10);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Headers
        $headers = ['รหัสสินค้า', 'ชื่อ', 'หมวดหมู่', 'ประเภท', 'หน่วย', 'คงเหลือ', 'ขั้นตํ่า', 'สถานที่', 'สถานะ'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $col++;
        }

        $this->setHeaderStyle($sheet, 4, count($headers));

        // Data
        $items = Item::with('category')->orderBy('item_code')->get();
        $row = 5;
        foreach ($items as $item) {
            $sheet->setCellValue('A' . $row, $item->item_code);
            $sheet->setCellValue('B' . $row, $item->name);
            $sheet->setCellValue('C' . $row, $item->category->name ?? '-');
            $sheet->setCellValue('D' . $row, match ($item->type) {
                'equipment' => 'อุปกรณ์',
                'consumable' => 'วัสดุสิ้นเปลือง',
                default => $item->type
            });
            $sheet->setCellValue('E' . $row, $item->unit);
            $sheet->setCellValue('F' . $row, $item->current_stock);
            $sheet->setCellValue('G' . $row, $item->min_stock);
            $sheet->setCellValue('H' . $row, $item->location ?? '-');
            $sheet->setCellValue('I' . $row, match ($item->status) {
                'available' => 'พร้อม',
                default => 'ไม่พร้อม'
            });
            $row++;
        }

        // Summary row
        $sheet->setCellValue('A' . $row, 'รวมทั้งหมด');
        $sheet->setCellValue('F' . $row, $items->sum('current_stock'));
        $sheet->setCellValue('G' . $row, $items->sum('min_stock'));
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('F' . $row)->getFont()->setBold(true);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(12);

        $this->setBorder($sheet, 4, $row, count($headers));

        $filename = 'items_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';
        return $this->downloadSpreadsheet($spreadsheet, $filename);
    }

    /**
     * Export borrowings to Excel (แยกตามบุคคล พร้อมรายการสินค้า)
     */
    public function exportBorrowings()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Title
        $sheet->setCellValue('A1', 'รายงานข้อมูลการยืม-คืนอุปกรณ์');
        $sheet->setCellValue('A2', 'วันที่ส่งออก: ' . Carbon::now()->format('d/m/Y H:i:s'));
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setSize(10);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ดึงข้อมูล + group by employee
        $borrowings = Requisition::with(['employee', 'employee.department', 'items', 'items.item'])
            ->where('req_type', 'borrow')
            ->latest()
            ->get();

        $groupedByEmployee = $borrowings->groupBy(function($b) {
            return $b->employee->id;
        });

        $row = 4;
        $totalBorrowings = 0;
        $totalItems = 0;

        foreach ($groupedByEmployee as $employeeId => $empBorrowings) {
            $employee = $empBorrowings->first()->employee;

            // Employee Header
            $sheet->setCellValue('A' . $row, 'พนักงาน: ' . $employee->firstname . ' ' . $employee->lastname);
            $sheet->setCellValue('C' . $row, 'รหัส: ' . $employee->employee_code);
            $sheet->setCellValue('D' . $row, 'แผนก: ' . ($employee->department->name ?? '-'));
            $sheet->mergeCells('A' . $row . ':H' . $row);
            $sheet->getStyle('A' . $row . ':H' . $row)->getFont()->setBold(true)->setSize(12);
            $sheet->getStyle('A' . $row . ':H' . $row)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E8F5E9');
            $row++;

            // Column Headers
            $headers = ['เลขที่', 'วันที่ยืม', 'กำหนดคืน', 'สถานะ', 'รหัสสินค้า', 'ชื่อสินค้า', 'จำนวนที่ยืม', 'คืนแล้ว', 'คงเหลือ', 'หมายเหตุ'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $row, $header);
                $col++;
            }
            $this->setHeaderStyle($sheet, $row, count($headers));
            $row++;

            $empStartRow = $row;

            foreach ($empBorrowings as $borrowing) {
                $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(Carbon::parse($borrowing->due_date));
                $statusText = match ($borrowing->status) {
                    'approved' => $isOverdue ? 'เกินกำหนด' : 'กำลังยืม',
                    'returned_all' => 'คืนครบแล้ว',
                    'returned_partial' => 'คืนบางส่วน',
                    default => $borrowing->status
                };

                $borrowStartRow = $row;

                foreach ($borrowing->items as $item) {
                    $qtyBorrowed = $item->quantity_requested ?? 0;
                    $qtyReturned = $item->quantity_returned ?? 0;
                    $qtyRemaining = $qtyBorrowed - $qtyReturned;

                    $sheet->setCellValue('A' . $row, '#' . str_pad($borrowing->id, 4, '0', STR_PAD_LEFT));
                    $sheet->setCellValue('B' . $row, Carbon::parse($borrowing->req_date)->format('d/m/Y'));
                    $sheet->setCellValue('C' . $row, Carbon::parse($borrowing->due_date)->format('d/m/Y'));
                    $sheet->setCellValue('D' . $row, $statusText);
                    $sheet->setCellValue('E' . $row, $item->item->item_code ?? '-');
                    $sheet->setCellValue('F' . $row, $item->item->name ?? '-');
                    $sheet->setCellValue('G' . $row, $qtyBorrowed);
                    $sheet->setCellValue('H' . $row, $qtyReturned);
                    $sheet->setCellValue('I' . $row, $qtyRemaining);
                    $sheet->setCellValue('J' . $row, $borrowing->note ?? '-');

                    $row++;
                    $totalItems++;
                }

                // Merge borrowing info
                $borrowEndRow = $row - 1;
                if ($borrowStartRow < $borrowEndRow) {
                    $sheet->mergeCells('A' . $borrowStartRow . ':A' . $borrowEndRow);
                    $sheet->mergeCells('B' . $borrowStartRow . ':B' . $borrowEndRow);
                    $sheet->mergeCells('C' . $borrowStartRow . ':C' . $borrowEndRow);
                    $sheet->mergeCells('D' . $borrowStartRow . ':D' . $borrowEndRow);
                    $sheet->mergeCells('J' . $borrowStartRow . ':J' . $borrowEndRow);
                }

                // Border between borrowings
                $sheet->getStyle('A' . ($row - 1) . ':J' . ($row - 1))->getBorders()
                    ->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                $totalBorrowings++;
            }

            // Employee summary
            $sheet->setCellValue('A' . $row, 'รวม ' . $employee->firstname . ' ' . $employee->lastname);
            $sheet->setCellValue('G' . $row, $empBorrowings->sum(fn($b) => $b->items->sum('quantity_requested')) . ' ชิ้น');
            $sheet->getStyle('A' . $row . ':G' . $row)->getFont()->setBold(true);
            $sheet->getStyle('A' . $row . ':J' . $row)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFF3E0');
            $row += 2; // Gap between employees
        }

        // Grand total
        $sheet->setCellValue('A' . $row, 'รวมทั้งหมด');
        $sheet->setCellValue('B' . $row, $totalBorrowings . ' ใบยืม');
        $sheet->setCellValue('C' . $row, $totalItems . ' รายการสินค้า');
        $sheet->getStyle('A' . $row . ':C' . $row)->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A' . $row . ':J' . $row)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E3F2FD');

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getColumnDimension('D')->setWidth(14);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(25);

        $filename = 'borrowings_by_employee_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';
        return $this->downloadSpreadsheet($spreadsheet, $filename);
    }

    /**
     * Export requisitions to Excel
     */
    public function exportRequisitions()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Title
        $sheet->setCellValue('A1', 'รายงานข้อมูลการเบิกอุปทาน');
        $sheet->setCellValue('A2', 'วันที่ส่งออก: ' . Carbon::now()->format('d/m/Y H:i:s'));
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setSize(10);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Headers
        $headers = ['เลขที่', 'วันที่เบิก', 'ผู้เบิก', 'สถานะ', 'ผู้อนุมัติ', 'จํานวนรายการ', 'หมายเหตุ'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $col++;
        }

        $this->setHeaderStyle($sheet, 4, count($headers));

        // Data
        $requisitions = Requisition::with(['employee', 'items', 'approver'])
            ->where('req_type', 'consume')
            ->latest()
            ->get();
        $row = 5;
        foreach ($requisitions as $req) {
            $statusText = match ($req->status) {
                'pending' => 'รออนุมัติ',
                'approved' => 'อนุมัติแล้ว',
                'rejected' => 'ปฏิเสธ',
                default => $req->status
            };

            $sheet->setCellValue('A' . $row, '#' . str_pad($req->id, 4, '0', STR_PAD_LEFT));
            $sheet->setCellValue('B' . $row, Carbon::parse($req->req_date)->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, $req->employee->firstname . ' ' . $req->employee->lastname);
            $sheet->setCellValue('D' . $row, $statusText);
            $sheet->setCellValue('E' . $row, $req->approver->name ?? '-');
            $sheet->setCellValue('F' . $row, $req->items->count() . ' รายการ');
            $sheet->setCellValue('G' . $row, $req->note ?? '-');
            $row++;
        }

        // Summary row
        $sheet->setCellValue('A' . $row, 'รวมทั้งหมด');
        $sheet->setCellValue('B' . $row, $requisitions->count() . ' รายการ');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(30);

        $this->setBorder($sheet, 4, $row, count($headers));

        $filename = 'requisitions_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';
        return $this->downloadSpreadsheet($spreadsheet, $filename);
    }

    /**
     * Export stock transactions to Excel with date filter
     */
    public function exportStockTransactions(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Title
        $sheet->setCellValue('A1', 'รายงานประวัติเคลื่อนไหวสต๊อก');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $dateFilterText = '';
        if ($dateFrom && $dateTo) {
            $dateFilterText = ' (' . Carbon::parse($dateFrom)->format('d/m/Y') . ' - ' . Carbon::parse($dateTo)->format('d/m/Y') . ')';
        }
        $sheet->setCellValue('A2', 'วันที่ส่งออก: ' . Carbon::now()->format('d/m/Y H:i:s') . $dateFilterText);
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setSize(10);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Headers
        $headers = ['ID', 'วันที่-เวลา', 'รหัสสินค้า', 'ชื่อสินค้า', 'ประเภท', 'จํานวน', 'คงเหลือ', 'ผู้ทํารายการ'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $col++;
        }

        $this->setHeaderStyle($sheet, 4, count($headers));

        // Data
        $query = StockTransaction::with(['item', 'creator']);
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        $transactions = $query->latest()->get();
        $row = 5;
        foreach ($transactions as $txn) {
            $typeText = match ($txn->transaction_type) {
                'borrow_out' => 'ยืมออก',
                'borrow_return' => 'คืนยืม',
                'consume_out' => 'เบิกใช้',
                'in' => 'เข้า',
                'out' => 'ออก',
                default => $txn->transaction_type
            };

            $sheet->setCellValue('A' . $row, $txn->id);
            $sheet->setCellValue('B' . $row, Carbon::parse($txn->created_at)->format('d/m/Y H:i'));
            $sheet->setCellValue('C' . $row, $txn->item->item_code ?? '-');
            $sheet->setCellValue('D' . $row, $txn->item->name ?? '-');
            $sheet->setCellValue('E' . $row, $typeText);
            $sheet->setCellValue('F' . $row, $txn->quantity);
            $sheet->setCellValue('G' . $row, $txn->balance);
            $sheet->setCellValue('H' . $row, $txn->creator->name ?? '-');
            $row++;
        }

        // Summary row
        $sheet->setCellValue('A' . $row, 'รวมทั้งหมด');
        $sheet->setCellValue('B' . $row, $transactions->count() . ' รายการ');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(20);

        $this->setBorder($sheet, 4, $row, count($headers));

        $filename = 'stock_transactions_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';
        return $this->downloadSpreadsheet($spreadsheet, $filename);
    }

    /**
     * Export time records summary to Excel
     */
    public function exportTimeRecords(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedMonth = $request->input('month_year', date('Y-m'));
        $monthName = Carbon::parse($selectedMonth . '-01')->format('F Y');

        // Title
        $sheet->setCellValue('A1', 'รายงานสรุปเวลาทํางานรายเดือน');
        $sheet->setCellValue('A2', 'ประจําเดือน: ' . $monthName);
        $sheet->setCellValue('A3', 'วันที่ส่งออก: ' . Carbon::now()->format('d/m/Y H:i:s'));
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3')->getFont()->setSize(10);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Headers
        $headers = ['รหัส', 'ชื่อ-นามสกุล', 'แผนก', 'มาปกติ', 'สาย', 'ลา', 'ขาด', 'รวมวัน'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '5', $header);
            $col++;
        }

        $this->setHeaderStyle($sheet, 5, count($headers));

        // Data
        $year = date('Y', strtotime($selectedMonth));
        $month = date('m', strtotime($selectedMonth));

        $employees = Employee::with(['department', 'timeRecords' => function ($query) use ($year, $month) {
            $query->whereYear('work_date', $year)->whereMonth('work_date', $month);
        }])->where('status', 'active')->get();

        $row = 6;
        foreach ($employees as $emp) {
            $present = 0;
            $late = 0;
            $leave = 0;
            $absent = 0;

            foreach ($emp->timeRecords as $record) {
                $status = strtolower($record->status);
                if ($status === 'present') {
                    $present++;
                } elseif ($status === 'late') {
                    $late++;
                } elseif ($status === 'leave') {
                    $leave++;
                } elseif ($status === 'absent') {
                    $absent++;
                }
            }

            $totalDays = $present + $late + $leave + $absent;

            $sheet->setCellValue('A' . $row, $emp->employee_code);
            $sheet->setCellValue('B' . $row, $emp->firstname . ' ' . $emp->lastname);
            $sheet->setCellValue('C' . $row, $emp->department->name ?? '-');
            $sheet->setCellValue('D' . $row, $present);
            $sheet->setCellValue('E' . $row, $late);
            $sheet->setCellValue('F' . $row, $leave);
            $sheet->setCellValue('G' . $row, $absent);
            $sheet->setCellValue('H' . $row, $totalDays);
            $row++;
        }

        // Summary row
        $sheet->setCellValue('A' . $row, 'รวมทั้งหมด');
        $sheet->setCellValue('B' . $row, $employees->count() . ' คน');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);

        $this->setBorder($sheet, 5, $row, count($headers));

        $filename = 'time_records_' . $selectedMonth . '_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';
        return $this->downloadSpreadsheet($spreadsheet, $filename);
    }

    /**
     * Download spreadsheet as xlsx
     */
    protected function downloadSpreadsheet($spreadsheet, $filename)
    {
        $writer = new Xlsx($spreadsheet);

        // Output to browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }
}
