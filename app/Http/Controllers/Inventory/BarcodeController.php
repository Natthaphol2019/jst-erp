<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BarcodeController extends Controller
{
    /**
     * Generate a barcode image (PNG) for the given item.
     * Uses the item_code as the barcode data.
     */
    public function generateBarcode(Item $item): Response
    {
        $barcodeData = $item->item_code;

        if (empty($barcodeData)) {
            abort(404, 'Item has no item_code for barcode generation.');
        }

        // Generate barcode as PNG (Code 128 format - supports alphanumeric)
        // Parameters: data, type, width factor, height factor, showCode
        $dns1d = app('DNS1D');
        $png = $dns1d->getBarcodePNG($barcodeData, 'C128', 1, 50, true);

        return response($png)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'public, max-age=31536000'); // Cache for 1 year
    }

    /**
     * Generate a QR code image (PNG) for the given item.
     * Encodes a URL to the item's detail page.
     */
    public function generateQrCode(Item $item): Response
    {
        // QR code contains the URL to the item's edit page
        $qrData = route('inventory.items.edit', $item->id);

        // Generate QR code as PNG (2D barcode)
        $dns2d = app('DNS2D');
        $png = $dns2d->getBarcodePNG($qrData, 'QRCODE', 4, 4);

        return response($png)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'public, max-age=31536000'); // Cache for 1 year
    }

    /**
     * Show the print barcode page for the given item.
     */
    public function printBarcode(Item $item)
    {
        return view('inventory.items.print-barcode', compact('item'));
    }
}
