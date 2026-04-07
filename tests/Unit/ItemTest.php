<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_an_item()
    {
        $category = ItemCategory::factory()->create();
        
        $item = Item::factory()->create([
            'category_id' => $category->id,
            'name' => 'Test Item',
            'item_code' => 'TEST001',
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Test Item',
            'item_code' => 'TEST001',
        ]);
    }

    #[Test]
    public function it_belongs_to_a_category()
    {
        $category = ItemCategory::factory()->create();
        $item = Item::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(ItemCategory::class, $item->category);
        $this->assertEquals($category->id, $item->category->id);
    }

    #[Test]
    public function it_has_many_transactions()
    {
        $employee = Employee::factory()->create();
        $user = User::factory()->create(['employee_id' => $employee->id]);
        $item = Item::factory()->create();
        
        StockTransaction::factory()->count(3)->create([
            'item_id' => $item->id,
            'created_by' => $user->id,
        ]);

        $this->assertCount(3, $item->transactions);
        $this->assertInstanceOf(StockTransaction::class, $item->transactions->first());
    }

    #[Test]
    public function it_prevents_negative_stock()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('สต๊อกสินค้า');

        $item = Item::factory()->make(['current_stock' => -5]);
        $item->save();
    }

    #[Test]
    public function it_can_be_disposable_type()
    {
        $item = Item::factory()->create(['type' => 'disposable']);

        $this->assertTrue($item->isDisposable());
        $this->assertFalse($item->isReturnable());
    }

    #[Test]
    public function it_can_be_returnable_type()
    {
        $item = Item::factory()->create(['type' => 'returnable']);

        $this->assertTrue($item->isReturnable());
        $this->assertFalse($item->isDisposable());
    }

    #[Test]
    public function it_returns_correct_type_label()
    {
        $disposable = Item::factory()->create(['type' => 'disposable']);
        $returnable = Item::factory()->create(['type' => 'returnable']);
        $equipment = Item::factory()->create(['type' => 'equipment']);
        $consumable = Item::factory()->create(['type' => 'consumable']);

        $this->assertEquals('ใช้แล้วหมดไป', $disposable->getTypeLabel());
        $this->assertEquals('ยืม-คืน', $returnable->getTypeLabel());
        $this->assertEquals('อุปกรณ์', $equipment->getTypeLabel());
        $this->assertEquals('สิ้นเปลือง', $consumable->getTypeLabel());
    }

    #[Test]
    public function it_returns_correct_type_badge_style()
    {
        $disposable = Item::factory()->create(['type' => 'disposable']);
        $returnable = Item::factory()->create(['type' => 'returnable']);
        $other = Item::factory()->create(['type' => 'equipment']);

        $disposableStyle = $disposable->getTypeBadgeStyle();
        $this->assertEquals('rgba(56,189,248,0.12)', $disposableStyle['bg']);
        $this->assertEquals('#38bdf8', $disposableStyle['color']);

        $returnableStyle = $returnable->getTypeBadgeStyle();
        $this->assertEquals('rgba(167,139,250,0.12)', $returnableStyle['bg']);
        $this->assertEquals('#a78bfa', $returnableStyle['color']);

        $otherStyle = $other->getTypeBadgeStyle();
        $this->assertEquals('rgba(107,114,128,0.12)', $otherStyle['bg']);
        $this->assertEquals('#9ca3af', $otherStyle['color']);
    }

    #[Test]
    public function it_casts_stock_values_to_integer()
    {
        $item = Item::factory()->create([
            'current_stock' => 100,
            'min_stock' => 50,
        ]);

        $this->assertIsInt($item->current_stock);
        $this->assertIsInt($item->min_stock);
    }

    #[Test]
    public function it_accepts_zero_stock()
    {
        $item = Item::factory()->create(['current_stock' => 0]);

        $this->assertEquals(0, $item->current_stock);
        $this->assertDatabaseHas('items', ['current_stock' => 0]);
    }

    #[Test]
    public function it_can_fill_fillable_attributes()
    {
        $item = Item::factory()->make();

        $fillable = $item->getFillable();
        $this->assertContains('category_id', $fillable);
        $this->assertContains('item_code', $fillable);
        $this->assertContains('name', $fillable);
        $this->assertContains('type', $fillable);
        $this->assertContains('unit', $fillable);
        $this->assertContains('current_stock', $fillable);
        $this->assertContains('min_stock', $fillable);
        $this->assertContains('location', $fillable);
        $this->assertContains('image_url', $fillable);
        $this->assertContains('status', $fillable);
    }

    #[Test]
    public function it_uses_soft_deletes()
    {
        $item = Item::factory()->create();
        $itemId = $item->id;

        $item->delete();

        $this->assertSoftDeleted('items', ['id' => $itemId]);
        $this->assertNull(Item::find($itemId));
        $this->assertNotNull(Item::withTrashed()->find($itemId));
    }

    #[Test]
    public function it_can_generate_barcode_url()
    {
        $item = Item::factory()->create();

        // We're just testing the method exists and returns a string
        $this->assertIsString($item->getBarcodeUrl());
    }

    #[Test]
    public function it_can_generate_qr_code_url()
    {
        $item = Item::factory()->create();

        $this->assertIsString($item->getQrCodeUrl());
    }

    #[Test]
    public function it_can_generate_print_barcode_url()
    {
        $item = Item::factory()->create();

        $this->assertIsString($item->getPrintBarcodeUrl());
    }
}
