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

        // Search by name, code, or location
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by unit
        if ($request->filled('unit')) {
            $query->where('unit', $request->unit);
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

        // Get all unique categories, types, and units for filters
        $allItems = Item::with('category')->get();
        $categories = $allItems->pluck('category.name')->unique()->filter()->values();
        $types = $allItems->pluck('type')->unique()->filter()->values();
        $units = $allItems->pluck('unit')->unique()->filter()->values();

        return view('inventory.items.index', compact('items', 'categories', 'types', 'units'));
    }

    // 2. หน้าฟอร์มเพิ่มสินค้าใหม่ (Create - Form)
    public function create()
    {
        // ดึงหมวดหมู่ทั้งหมดพร้อม code_prefix
        $categories = ItemCategory::all();
        
        return view('inventory.items.create', compact('categories'));
    }

    // 3. ฟังก์ชันสร้างรหัสสินค้าอัตโนมัติ
    public function generateCode(Request $request)
    {
        $categoryId = $request->category_id;
        $category = ItemCategory::find($categoryId);
        
        if (!$category || !$category->code_prefix) {
            return response()->json(['error' => 'Category not found or no prefix'], 400);
        }
        
        // นับจำนวนสินค้าในหมวดหมู่นี้
        $count = Item::where('category_id', $categoryId)
            ->withTrashed()
            ->count();
        
        $nextNumber = $count + 1;
        $newCode = $category->code_prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        
        return response()->json([
            'code' => $newCode,
            'prefix' => $category->code_prefix,
            'number' => $nextNumber
        ]);
    }

    // 3. บันทึกข้อมูลสินค้าใหม่ลงฐานข้อมูล (Create - Store)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:item_categories,id',
            'item_code'   => 'required|string|max:50|unique:items,item_code',
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:disposable,returnable,equipment,consumable',
            'unit'        => 'required|string|max:50',
            'current_stock'=> 'nullable|integer|min:0',
            'min_stock'   => 'nullable|integer|min:0',
            'location'    => 'nullable|string|max:100',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        // จัดการอัปโหลดรูปภาพ
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            
            // สร้าง directory ถ้ายังไม่มี
            $targetDir = storage_path('app/public/items');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            
            $targetPath = $targetDir . '/' . $imageName;
            copy($image->getPathname(), $targetPath);
            
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
            'type'        => 'required|in:disposable,returnable,equipment,consumable',
            'unit'        => 'required|string|max:50',
            'current_stock'=> 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'location'    => 'nullable|string|max:100',
            'status'      => 'required|in:available,unavailable,maintenance',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
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