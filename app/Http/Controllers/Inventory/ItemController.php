<?php
namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // 1. หน้าแสดงรายการสินค้าทั้งหมด (Read - List)
    public function index()
    {
        // ดึงข้อมูลสินค้า พร้อมหมวดหมู่ (category) เรียงจากใหม่ไปเก่า
        $items = Item::with('category')->latest()->paginate(10);
        return view('inventory.items.index', compact('items'));
    }

    // 2. หน้าฟอร์มเพิ่มสินค้าใหม่ (Create - Form)
    public function create()
    {
        // ดึงหมวดหมู่ทั้งหมดมาเพื่อใช้ใน Dropdown
        $categories = ItemCategory::all();
        return view('inventory.items.create', compact('categories'));
    }

    // 3. บันทึกข้อมูลสินค้าใหม่ลงฐานข้อมูล (Create - Store)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:item_categories,id',
            'item_code'   => 'required|string|max:50|unique:items,item_code', // ต้องไม่ซ้ำ
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:equipment,consumable', // ต้องเป็น 2 ค่านี้เท่านั้น
            'unit'        => 'required|string|max:50',
            'current_stock'=> 'nullable|integer|min:0',
            'min_stock'   => 'nullable|integer|min:0',
            'location'    => 'nullable|string|max:100',
        ]);

        Item::create($validated);

        return redirect()->route('inventory.items.index')
                         ->with('success', 'เพิ่มรหัสสินค้าใหม่เรียบร้อยแล้ว');
    }

    // 4. หน้าแสดงฟอร์มแก้ไขสินค้า (Update - Form)
    public function edit(Item $item)
    {
        $categories = ItemCategory::all();
        return view('inventory.items.edit', compact('item', 'categories'));
    }

    // 5. บันทึกข้อมูลที่แก้ไขลงฐานข้อมูล (Update - Save)
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:item_categories,id',
            // ยกเว้นการเช็ค unique กับ ID ของตัวเอง
            'item_code'   => 'required|string|max:50|unique:items,item_code,' . $item->id,
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:equipment,consumable',
            'unit'        => 'required|string|max:50',
            'current_stock'=> 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'location'    => 'nullable|string|max:100',
            'status'      => 'required|in:available,unavailable,maintenance',
        ]);

        $item->update($validated);

        return redirect()->route('inventory.items.index')
                         ->with('success', 'อัปเดตข้อมูลสินค้าเรียบร้อยแล้ว');
    }

    // 6. ลบข้อมูลสินค้า (Delete)
    public function destroy(Item $item)
    {
        // คำแนะนำ: ในระบบ ERP จริงๆ มักจะไม่ลบ (delete) ข้อมูล Master Data ออกจากระบบ 
        // หากสินค้านั้นเคยมีการเคลื่อนไหว (Transaction) แล้ว แนะนำให้ปรับ status เป็น unavailable แทนครับ
        // แต่ในเบื้องต้นทำเป็น Delete ไปก่อนเพื่อทดสอบ CRUD ได้ครับ
        
        $item->delete();

        return redirect()->route('inventory.items.index')
                         ->with('success', 'ลบสินค้าเรียบร้อยแล้ว');
    }
}