@extends('layouts.app')

@section('title', 'พิมพ์บาร์โค้ด - ' . $item->item_code)

@section('content')
<style>
    /* Label sizes - common standards */
    .label-40x25 {
        width: 40mm;
        height: 25mm;
        padding: 2mm;
        page-break-inside: avoid;
    }
    .label-50x30 {
        width: 50mm;
        height: 30mm;
        padding: 3mm;
        page-break-inside: avoid;
    }
    .label-60x40 {
        width: 60mm;
        height: 40mm;
        padding: 3mm;
        page-break-inside: avoid;
    }

    .label-container {
        display: inline-block;
        border: 1px dashed #ccc;
        text-align: center;
        vertical-align: top;
        margin: 5mm;
        background: #fff;
    }

    .label-container .item-code {
        font-size: 9pt;
        font-weight: bold;
        margin: 0;
        line-height: 1.2;
    }

    .label-container .item-name {
        font-size: 7pt;
        color: #333;
        margin: 1mm 0;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .label-container .barcode-img {
        margin: 1mm auto;
    }

    .label-container .item-price {
        font-size: 8pt;
        font-weight: bold;
        margin: 1mm 0 0;
    }

    @media print {
        .no-print, .no-print * { display: none !important; }
        body { background: #fff !important; }
        .label-container {
            border: none !important;
            margin: 0 !important;
        }
        @page {
            size: auto;
            margin: 5mm;
        }
    }
</style>

<div class="container-fluid p-4">
    {{-- Control Panel (hidden when printing) --}}
    <div class="card mb-4 no-print">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-upc-scan me-2"></i>พิมพ์บาร์โค้ด - {{ $item->item_code }}</h5>
        </div>
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label for="labelSize" class="form-label fw-bold">ขนาดป้าย</label>
                    <select id="labelSize" class="form-select">
                        <option value="label-40x25">40 x 25 มม. (เล็ก)</option>
                        <option value="label-50x30" selected>50 x 30 มม. (กลาง)</option>
                        <option value="label-60x40">60 x 40 มม. (ใหญ่)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="copies" class="form-label fw-bold">จำนวนสำเนา</label>
                    <input type="number" id="copies" class="form-control" value="1" min="1" max="100">
                </div>
                <div class="col-md-6">
                    <button id="btnUpdate" class="btn btn-outline-primary me-2">
                        <i class="bi bi-arrow-repeat me-1"></i>อัปเดตตัวอย่าง
                    </button>
                    <button id="btnPrint" class="btn btn-success">
                        <i class="bi bi-printer me-1"></i>พิมพ์
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary ms-2">
                        <i class="bi bi-arrow-left me-1"></i>ย้อนกลับ
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Preview Area --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="bi bi-eye me-2"></i>ตัวอย่างป้าย</h6>
        </div>
        <div class="card-body">
            <div id="labelsPreview" class="text-center">
                {{-- Labels will be rendered here --}}
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const item = @json($item);
    const barcodeUrl = '{{ route('inventory.items.barcode', $item->id) }}';

    function renderLabels() {
        const size = document.getElementById('labelSize').value;
        const copies = Math.min(parseInt(document.getElementById('copies').value) || 1, 100);
        const preview = document.getElementById('labelsPreview');

        let html = '';
        for (let i = 0; i < copies; i++) {
            html += '<div class="label-container ' + size + '">' +
                    '<div class="p-2">' +
                    '<p class="item-code">' + escapeHtml(item.item_code) + '</p>' +
                    '<img src="' + barcodeUrl + '" alt="barcode" class="barcode-img" ' +
                    'style="max-width: 90%; max-height: 20mm;" loading="lazy">' +
                    '<p class="item-name">' + escapeHtml(item.name) + '</p>' +
                    '</div></div>';
        }
        preview.innerHTML = html;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Initial render
    renderLabels();

    // Event listeners
    document.getElementById('btnUpdate').addEventListener('click', renderLabels);
    document.getElementById('btnPrint').addEventListener('click', function() {
        window.print();
    });

    // Auto-update on change
    document.getElementById('labelSize').addEventListener('change', renderLabels);
    document.getElementById('copies').addEventListener('change', renderLabels);
})();
</script>
@endsection
