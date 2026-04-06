<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการยืม-คืนอุปกรณ์ทั้งหมด</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Noto Sans Thai', 'Tahoma', 'Segoe UI', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #000;
            padding: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 9pt;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead { background: #ddd; }
        th, td {
            border: 1px solid #999;
            padding: 5px 6px;
            text-align: left;
            font-size: 9pt;
        }
        th { font-weight: bold; font-size: 9pt; }
        .text-center { text-align: center; }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        @media print {
            body { padding: 10px; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>รายการยืม-คืนอุปกรณ์ทั้งหมด</h1>
        <p>พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }} | รวม {{ $borrowings->count() }} ใบยืม</p>
    </div>

    @if($borrowings->isEmpty())
        <p style="text-align: center; margin-top: 30px; color: #999;">ไม่พบข้อมูลใบยืม</p>
    @else
        <table>
            <thead>
                <tr>
                    <th width="8%">เลขที่</th>
                    <th width="10%">วันที่ยืม</th>
                    <th width="10%">กำหนดคืน</th>
                    <th width="20%">ผู้ยืม</th>
                    <th width="12%">สถานะ</th>
                    <th width="20%">รายการ</th>
                    <th width="20%">หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowings as $borrowing)
                    @php
                        $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                        $statusText = match($borrowing->status) {
                            'approved' => $isOverdue ? 'เกินกำหนด' : 'กำลังยืม',
                            'returned_all' => 'คืนครบแล้ว',
                            'returned_partial' => 'คืนบางส่วน',
                            'rejected' => 'ปฏิเสธ',
                            default => $borrowing->status
                        };
                        $itemNames = $borrowing->items->map(fn($i) => $i->item->name ?? '-')->implode(', ');
                    @endphp
                    <tr>
                        <td class="text-center"><strong>#{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</td>
                        <td>{{ $borrowing->employee->firstname }} {{ $borrowing->employee->lastname }}<br><small style="color: #666;">{{ $borrowing->employee->employee_code }}</small></td>
                        <td class="text-center">{{ $statusText }}</td>
                        <td>{{ $itemNames }}</td>
                        <td>{{ $borrowing->note ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        JST ERP System | รายการยืม-คืนอุปกรณ์ | พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>
