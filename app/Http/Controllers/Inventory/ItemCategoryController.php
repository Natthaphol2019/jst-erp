<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    public function index()
    {
        $categories = ItemCategory::withCount('items')->latest()->paginate(15);
        return view('inventory.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('inventory.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:item_categories,name',
            'code_prefix' => 'nullable|string|max:10|unique:item_categories,code_prefix',
            'description' => 'nullable|string|max:500',
        ]);

        ItemCategory::create($validated);

        return redirect()->route('inventory.categories.index')
            ->with('success', 'เพิ่มหมวดหมู่สินค้าเรียบร้อยแล้ว');
    }

    public function edit(ItemCategory $category)
    {
        return view('inventory.categories.edit', compact('category'));
    }

    public function update(Request $request, ItemCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:item_categories,name,' . $category->id,
            'code_prefix' => 'nullable|string|max:10|unique:item_categories,code_prefix,' . $category->id,
            'description' => 'nullable|string|max:500',
        ]);

        $category->update($validated);

        return redirect()->route('inventory.categories.index')
            ->with('success', 'แก้ไขหมวดหมู่สินค้าเรียบร้อยแล้ว');
    }

    public function destroy(ItemCategory $category)
    {
        // ตรวจสอบว่ามีสินค้าในหมวดหมู่นี้หรือไม่
        if ($category->items()->count() > 0) {
            return back()->withErrors(['error' => 'ไม่สามารถลบหมวดหมู่ที่มีสินค้าอยู่']);
        }

        $category->delete();

        return redirect()->route('inventory.categories.index')
            ->with('success', 'ลบหมวดหมู่สินค้าเรียบร้อยแล้ว');
    }
}
