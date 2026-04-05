<?php
namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // 1. หน้าแสดงรายการสินค้าทั้งหมด (Read - List)
    public function index(Request $request)
    {
        $query = Item::with('category');
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: show only available items
            $query->where('status', 'available');
        }
        
        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'stock':
                $query->orderBy('current_stock', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }
        
        $items = $query->paginate(10)->appends($request->query());
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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // จัดการอัปโหลดรูปภาพ
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/items', $imageName);
            $validated['image_url'] = 'items/' . $imageName;
        }

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

    // 4.5 หน้าแสดงรายละเอียดสินค้า (Show - Details)
    public function show(Item $item)
    {
        $item->load('category');
        return view('inventory.items.show', compact('item'));
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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // จัดการอัปโหลดรูปภาพใหม่
        if ($request->hasFile('image')) {
            // ลบรูปเก่าถ้ามี
            if ($item->image_url) {
                \Storage::delete('public/' . $item->image_url);
            }
            
            // ใช้วิธี copy file โดยตรง
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $targetDir = storage_path('app/public/items');
            $targetPath = $targetDir . '/' . $imageName;
            
            // สร้าง directory ถ้ายังไม่มี
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            
            // copy file
            $moved = copy($image->getPathname(), $targetPath);
            \Log::info('Image uploaded: ' . $targetPath . ' - Result: ' . ($moved ? 'success' : 'failed'));
            
            $validated['image_url'] = 'items/' . $imageName;
        } elseif ($request->input('remove_image') == '1') {
            // ลบรูปเก่าถ้าผู้ใช้ต้องการลบ
            if ($item->image_url) {
                \Storage::delete('public/' . $item->image_url);
            }
            $validated['image_url'] = null;
        }

        $item->update($validated);

        return redirect()->route('inventory.items.index')
                         ->with('success', 'อัปเดตข้อมูลสินค้าเรียบร้อยแล้ว');
    }

    // 6. ลบข้อมูลสินค้า (Delete)
    public function destroy(Item $item)
    {
        // ลบรูปภาพถ้ามี
        if ($item->image_url) {
            \Storage::delete('public/' . $item->image_url);
        }

        $item->delete();

        return redirect()->route('inventory.items.index')
                         ->with('success', 'ลบสินค้าเรียบร้อยแล้ว');
    }

    // 7. สลับสถานะสินค้า (พร้อมใช้งาน <-> ไม่พร้อมใช้งาน)
    public function toggleStatus(Item $item)
    {
        if ($item->status == 'available') {
            $item->update(['status' => 'unavailable']);
            return redirect()->route('inventory.items.index')
                             ->with('success', 'เปลี่ยนสถานะเป็น "ไม่พร้อมใช้งาน" เรียบร้อยแล้ว');
        } else {
            $item->update(['status' => 'available']);
            return redirect()->route('inventory.items.index')
                             ->with('success', 'เปลี่ยนสถานะเป็น "พร้อมใช้งาน" เรียบร้อยแล้ว');
        }
    }
}