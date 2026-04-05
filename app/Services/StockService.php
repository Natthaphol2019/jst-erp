<?php

namespace App\Services;

use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class StockService
{
    /**
     * หักสต๊อกแบบ atomic พร้อม lock
     *
     * @param int $itemId รหัสสินค้า
     * @param int $quantity จำนวนที่หัก
     * @param string $transactionType ประเภทธุรกรรม (consume_out, borrow_out)
     * @param int|null $requisitionId รหัสใบเบิก/ใบยืม
     * @param int|null $userId รหัสผู้ใช้ที่ท าการ
     * @param string|null $remark หมายเหตุ
     * @return array ['item' => Item, 'new_stock' => int]
     * @throws Exception เมื่อสต๊อกไม่เพียงพอ
     */
    public function deductStock(
        int $itemId,
        int $quantity,
        string $transactionType,
        ?int $requisitionId = null,
        ?int $userId = null,
        ?string $remark = null
    ): array {
        return DB::transaction(function () use ($itemId, $quantity, $transactionType, $requisitionId, $userId, $remark) {
            // Lock row เพื่อป้องกัน race condition
            $item = Item::where('id', $itemId)->lockForUpdate()->first();

            if (!$item) {
                Log::warning('StockService: Item not found', ['item_id' => $itemId]);
                throw new Exception("ไม่พบสินค้ารหัส {$itemId}");
            }

            // ตรวจสอบสต๊อกภายใน transaction
            if ($item->current_stock < $quantity) {
                Log::warning('StockService: Insufficient stock', [
                    'item_id' => $itemId,
                    'item_name' => $item->name,
                    'requested' => $quantity,
                    'available' => $item->current_stock,
                ]);

                throw new Exception(
                    "สินค้า {$item->name} มีไม่เพียงพอ " .
                    "(ต้องการ: {$quantity}, คงเหลือ: {$item->current_stock})"
                );
            }

            // หักสต๊อก
            $newStock = $item->current_stock - $quantity;
            $item->update(['current_stock' => $newStock]);

            // บันทึก transaction
            StockTransaction::create([
                'item_id' => $item->id,
                'transaction_type' => $transactionType,
                'quantity' => $quantity,
                'balance' => $newStock,
                'requisition_id' => $requisitionId,
                'created_by' => $userId,
                'remark' => $remark,
            ]);

            Log::info('StockService: Stock deducted', [
                'item_id' => $itemId,
                'quantity' => $quantity,
                'new_stock' => $newStock,
                'transaction_type' => $transactionType,
            ]);

            return [
                'item' => $item,
                'new_stock' => $newStock,
            ];
        });
    }

    /**
     * เพิ่มสต๊อกแบบ atomic พร้อม lock
     *
     * @param int $itemId รหัสสินค้า
     * @param int $quantity จำนวนที่เพิ่ม
     * @param string $transactionType ประเภทธุรกรรม (borrow_return, stock_in)
     * @param int|null $requisitionId รหัสใบเบิก/ใบยืม
     * @param int|null $userId รหัสผู้ใช้ที่ท าการ
     * @param string|null $remark หมายเหตุ
     * @return array ['item' => Item, 'new_stock' => int]
     * @throws Exception เมื่อเกิดข้อผิดพลาด
     */
    public function addStock(
        int $itemId,
        int $quantity,
        string $transactionType,
        ?int $requisitionId = null,
        ?int $userId = null,
        ?string $remark = null
    ): array {
        return DB::transaction(function () use ($itemId, $quantity, $transactionType, $requisitionId, $userId, $remark) {
            // Lock row เพื่อป้องกัน race condition
            $item = Item::where('id', $itemId)->lockForUpdate()->first();

            if (!$item) {
                Log::warning('StockService: Item not found', ['item_id' => $itemId]);
                throw new Exception("ไม่พบสินค้ารหัส {$itemId}");
            }

            // เพิ่มสต๊อก
            $newStock = $item->current_stock + $quantity;
            $item->update(['current_stock' => $newStock]);

            // บันทึก transaction
            StockTransaction::create([
                'item_id' => $item->id,
                'transaction_type' => $transactionType,
                'quantity' => $quantity,
                'balance' => $newStock,
                'requisition_id' => $requisitionId,
                'created_by' => $userId,
                'remark' => $remark,
            ]);

            Log::info('StockService: Stock added', [
                'item_id' => $itemId,
                'quantity' => $quantity,
                'new_stock' => $newStock,
                'transaction_type' => $transactionType,
            ]);

            return [
                'item' => $item,
                'new_stock' => $newStock,
            ];
        });
    }

    /**
     * ตรวจสอบสต๊อกปัจจุบัน (อ่านอย่างเดียว ไม่ใช้ lock)
     *
     * @param int $itemId รหัสสินค้า
     * @return int จำนวนสต๊อกปัจจุบัน
     */
    public function checkStock(int $itemId): int
    {
        $item = Item::find($itemId);

        if (!$item) {
            return 0;
        }

        return $item->current_stock;
    }

    /**
     * ตรวจสอบสต๊อกหลายรายการภายใน transaction เดียวกัน
     * ใช้สำหรับตรวจสอบก่อนสร้างใบเบิก/ใบยืม
     *
     * @param array $items [[item_id => int, quantity => int], ...]
     * @return bool true เมื่อสต๊อกเพียงพอทั้งหมด
     * @throws Exception เมื่อสต๊อกไม่เพียงพอ พร้อมรายละเอียดสินค้า
     */
    public function checkStockAvailability(array $items): bool
    {
        foreach ($items as $itemData) {
            $item = Item::find($itemData['item_id']);

            if (!$item) {
                throw new Exception("ไม่พบสินค้ารหัส {$itemData['item_id']}");
            }

            if ($item->current_stock < $itemData['quantity']) {
                throw new Exception(
                    "สินค้า {$item->name} มีไม่เพียงพอ " .
                    "(ต้องการ: {$itemData['quantity']}, คงเหลือ: {$item->current_stock})"
                );
            }
        }

        return true;
    }

    /**
     * หักสต๊อกหลายรายการภายใน transaction เดียวกัน
     *
     * @param array $items [[item_id => int, quantity => int], ...]
     * @param string $transactionType ประเภทธุรกรรม
     * @param int|null $requisitionId รหัสใบเบิก/ใบยืม
     * @param int|null $userId รหัสผู้ใช้ที่ท าการ
     * @param string|null $remark หมายเหตุ
     * @return array ผลลัพธ์แต่ละรายการ
     * @throws Exception เมื่อเกิดข้อผิดพลาด (rollback อัตโนมัติ)
     */
    public function deductMultipleStock(
        array $items,
        string $transactionType,
        ?int $requisitionId = null,
        ?int $userId = null,
        ?string $remark = null
    ): array {
        return DB::transaction(function () use ($items, $transactionType, $requisitionId, $userId, $remark) {
            $results = [];

            // เรียงลำดับ item_id เพื่อป้องกัน deadlock
            $sortedItems = collect($items)->sortBy('item_id')->values()->all();

            foreach ($sortedItems as $itemData) {
                $result = $this->deductStock(
                    itemId: $itemData['item_id'],
                    quantity: $itemData['quantity'],
                    transactionType: $transactionType,
                    requisitionId: $requisitionId,
                    userId: $userId,
                    remark: $remark
                );

                $results[] = $result;
            }

            return $results;
        });
    }

    /**
     * เพิ่มสต๊อกหลายรายการภายใน transaction เดียวกัน
     *
     * @param array $items [[item_id => int, quantity => int], ...]
     * @param string $transactionType ประเภทธุรกรรม
     * @param int|null $requisitionId รหัสใบเบิก/ใบยืม
     * @param int|null $userId รหัสผู้ใช้ที่ท าการ
     * @param string|null $remark หมายเหตุ
     * @return array ผลลัพธ์แต่ละรายการ
     * @throws Exception เมื่อเกิดข้อผิดพลาด (rollback อัตโนมัติ)
     */
    public function addMultipleStock(
        array $items,
        string $transactionType,
        ?int $requisitionId = null,
        ?int $userId = null,
        ?string $remark = null
    ): array {
        return DB::transaction(function () use ($items, $transactionType, $requisitionId, $userId, $remark) {
            $results = [];

            // เรียงลำดับ item_id เพื่อป้องกัน deadlock
            $sortedItems = collect($items)->sortBy('item_id')->values()->all();

            foreach ($sortedItems as $itemData) {
                $result = $this->addStock(
                    itemId: $itemData['item_id'],
                    quantity: $itemData['quantity'],
                    transactionType: $transactionType,
                    requisitionId: $requisitionId,
                    userId: $userId,
                    remark: $remark
                );

                $results[] = $result;
            }

            return $results;
        });
    }
}
