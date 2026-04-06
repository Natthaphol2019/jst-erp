<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พิมพ์ใบยืม #{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Noto Sans Thai', 'Tahoma', 'Segoe UI', sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }
        .header h1 {
            font-size: 20pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 10pt;
            color: #666;
        }
        .section {
            margin-bottom: 20px;
            border: 1px solid #999;
            page-break-inside: avoid;
        }
        .section-title {
            background: #eee;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 12pt;
            border-bottom: 1px solid #999;
        }
        .row {
            display: table;
            width: 100%;
            border-bottom: 1px solid #ddd;
        }
        .row:last-child { border-bottom: none; }
        .label {
            display: table-cell;
            width: 130px;
            padding: 8px 10px;
            background: #f5f5f5;
            font-size: 11pt;
            font-weight: bold;
            border-right: 1px solid #ddd;
        }
        .value {
            display: table-cell;
            padding: 8px 10px;
            font-size: 12pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead { background: #ddd; }
        th, td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
        }
        th { font-weight: bold; }
        tfoot { font-weight: bold; background: #f5f5f5; }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 9pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        @media print {
            body { padding: 10px; }
            .section { page-break-inside: avoid; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>ใบยืม-คืนอุปกรณ์</h1>
        <p>เลขที่ #{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }} | พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="section">
        <div class="section-title">ข้อมูลใบยืม</div>
        <div class="row">
            <div class="label">เลขที่ใบยืม</div>
            <div class="value"><strong>#{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}</strong></div>
        </div>
        <div class="row">
            <div class="label">วันที่ยืม</div>
            <div class="value">{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</div>
        </div>
        <div class="row">
            <div class="label">กำหนดคืน</div>
            <div class="value">
                {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                @php
                    $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                @endphp
                @if($isOverdue)
                    <span style="color: #ef4444; font-weight: bold;"> (เกินกำหนด {{ now()->diffInDays(\Carbon\Carbon::parse($borrowing->due_date)) }} วัน)</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="label">สถานะ</div>
            <div class="value">
                @php
                    $statusText = match($borrowing->status) {
                        'approved' => $isOverdue ? 'เกินกำหนด' : 'กำลังยืม',
                        'returned_all' => 'คืนครบแล้ว',
                        'returned_partial' => 'คืนบางส่วน',
                        'rejected' => 'ปฏิเสธ',
                        default => $borrowing->status
                    };
                @endphp
                {{ $statusText }}
            </div>
        </div>
        <div class="row">
            <div class="label">ผู้อนุมัติ</div>
            <div class="value">{{ $borrowing->approver->name ?? '-' }}</div>
        </div>
        @if($borrowing->note)
        <div class="row">
            <div class="label">หมายเหตุ</div>
            <div class="value">{{ $borrowing->note }}</div>
        </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">ข้อมูลผู้ยืม</div>
        <div class="row">
            <div class="label">รหัสพนักงาน</div>
            <div class="value">{{ $borrowing->employee->employee_code }}</div>
        </div>
        <div class="row">
            <div class="label">ชื่อ-นามสกุล</div>
            <div class="value"><strong>{{ $borrowing->employee->firstname }} {{ $borrowing->employee->lastname }}</strong></div>
        </div>
        @if($borrowing->employee->department)
        <div class="row">
            <div class="label">แผนก</div>
            <div class="value">{{ $borrowing->employee->department->name }}</div>
        </div>
        @endif
        @if($borrowing->employee->position)
        <div class="row">
            <div class="label">ตำแหน่ง</div>
            <div class="value">{{ $borrowing->employee->position->name }}</div>
        </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">รายการสินค้ายืม</div>
        <table>
            <thead>
                <tr>
                    <th>สินค้า</th>
                    <th style="width: 60px; text-align: center;">ยืม</th>
                    <th style="width: 60px; text-align: center;">คืนแล้ว</th>
                    <th style="width: 60px; text-align: center;">คงเหลือ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowing->items as $item)
                    <tr>
                        <td>{{ $item->item->name }}</td>
                        <td style="text-align: center;">{{ $item->quantity_requested }}</td>
                        <td style="text-align: center;">{{ $item->quantity_returned }}</td>
                        <td style="text-align: center;"><strong>{{ $item->quantity_requested - $item->quantity_returned }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>รวม</th>
                    <th style="text-align: center;">{{ $borrowing->items->sum('quantity_requested') }}</th>
                    <th style="text-align: center;">{{ $borrowing->items->sum('quantity_returned') }}</th>
                    <th style="text-align: center;">{{ $borrowing->items->sum(fn($i) => $i->quantity_requested - $i->quantity_returned) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        JST ERP System | พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>
