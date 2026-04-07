<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ItemCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->admin()->create();
    }

    #[Test]
    public function it_can_view_items_index_page()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('inventory.items.index'));

        $response->assertStatus(200);
        $response->assertViewIs('inventory.items.index');
        $response->assertViewHas('items');
    }

    #[Test]
    public function it_can_view_create_item_form()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('inventory.items.create'));

        $response->assertStatus(200);
        $response->assertViewIs('inventory.items.create');
        $response->assertViewHas('categories');
    }

    #[Test]
    public function it_can_create_a_new_item()
    {
        $category = ItemCategory::factory()->create();

        $itemData = [
            'category_id' => $category->id,
            'item_code' => 'TEST001',
            'name' => 'Test Item',
            'type' => 'disposable',
            'unit' => 'piece',
            'current_stock' => 100,
            'min_stock' => 10,
            'location' => 'Warehouse A',
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('inventory.items.store'), $itemData);

        $this->assertDatabaseHas('items', [
            'item_code' => 'TEST001',
            'name' => 'Test Item',
            'type' => 'disposable',
        ]);

        $response->assertRedirect(route('inventory.items.index'));
        $response->assertSessionHas('success');
    }

    #[Test]
    public function it_requires_valid_item_data()
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('inventory.items.store'), [
                'category_id' => '',
                'item_code' => '',
                'name' => '',
                'type' => 'invalid_type',
                'unit' => '',
            ]);

        $response->assertSessionHasErrors(['category_id', 'item_code', 'name', 'type', 'unit']);
    }

    #[Test]
    public function it_requires_unique_item_code()
    {
        $category = ItemCategory::factory()->create();
        Item::factory()->create(['item_code' => 'DUP001']);

        $response = $this->actingAs($this->adminUser)
            ->post(route('inventory.items.store'), [
                'category_id' => $category->id,
                'item_code' => 'DUP001',
                'name' => 'Duplicate Item',
                'type' => 'disposable',
                'unit' => 'piece',
            ]);

        $response->assertSessionHasErrors('item_code');
    }

    #[Test]
    public function it_can_view_item_details()
    {
        $item = Item::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->get(route('inventory.items.show', $item));

        $response->assertStatus(200);
        $response->assertViewIs('inventory.items.show');
        $response->assertViewHas('item');
    }

    #[Test]
    public function it_can_view_edit_form()
    {
        $item = Item::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->get(route('inventory.items.edit', $item));

        $response->assertStatus(200);
        $response->assertViewIs('inventory.items.edit');
        $response->assertViewHas('item');
        $response->assertViewHas('categories');
    }

    #[Test]
    public function it_can_update_an_item()
    {
        $item = Item::factory()->create();
        $newCategory = ItemCategory::factory()->create();

        $updatedData = [
            'category_id' => $newCategory->id,
            'item_code' => $item->item_code,
            'name' => 'Updated Item Name',
            'type' => 'returnable',
            'unit' => 'box',
            'current_stock' => 200,
            'min_stock' => 20,
            'location' => 'Warehouse B',
            'status' => 'available',
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('inventory.items.update', $item), $updatedData);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'name' => 'Updated Item Name',
            'type' => 'returnable',
        ]);

        $response->assertRedirect(route('inventory.items.index'));
        $response->assertSessionHas('success');
    }

    #[Test]
    public function it_can_upload_image_when_creating_item()
    {
        Storage::fake('public');
        $category = ItemCategory::factory()->create();
        $image = UploadedFile::fake()->image('test.jpg');

        $response = $this->actingAs($this->adminUser)
            ->post(route('inventory.items.store'), [
                'category_id' => $category->id,
                'item_code' => 'IMG001',
                'name' => 'Item With Image',
                'type' => 'disposable',
                'unit' => 'piece',
                'current_stock' => 50,
                'min_stock' => 5,
                'image' => $image,
            ]);

        $response->assertRedirect(route('inventory.items.index'));
        $this->assertDatabaseHas('items', ['item_code' => 'IMG001']);
    }

    #[Test]
    public function it_can_upload_image_when_updating_item()
    {
        Storage::fake('public');
        $item = Item::factory()->create();
        Storage::fake('public')->put('public/' . $item->image_url, 'old image content');

        $newImage = UploadedFile::fake()->image('new-image.jpg');

        $response = $this->actingAs($this->adminUser)
            ->put(route('inventory.items.update', $item), [
                'category_id' => $item->category_id,
                'item_code' => $item->item_code,
                'name' => $item->name,
                'type' => $item->type,
                'unit' => $item->unit,
                'current_stock' => $item->current_stock,
                'min_stock' => $item->min_stock,
                'status' => $item->status,
                'image' => $newImage,
            ]);

        $response->assertRedirect(route('inventory.items.index'));
    }

    #[Test]
    public function it_can_remove_image_when_updating_item()
    {
        $item = Item::factory()->create(['image_url' => 'items/old_image.jpg']);
        Storage::fake('public')->put('public/items/old_image.jpg', 'image content');

        $response = $this->actingAs($this->adminUser)
            ->put(route('inventory.items.update', $item), [
                'category_id' => $item->category_id,
                'item_code' => $item->item_code,
                'name' => $item->name,
                'type' => $item->type,
                'unit' => $item->unit,
                'current_stock' => $item->current_stock,
                'min_stock' => $item->min_stock,
                'status' => $item->status,
                'remove_image' => '1',
            ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'image_url' => null,
        ]);

        $response->assertRedirect(route('inventory.items.index'));
    }

    #[Test]
    public function it_can_delete_an_item()
    {
        $item = Item::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->delete(route('inventory.items.destroy', $item));

        $this->assertSoftDeleted('items', ['id' => $item->id]);
        $response->assertRedirect(route('inventory.items.index'));
        $response->assertSessionHas('success');
    }

    #[Test]
    public function it_can_toggle_item_status()
    {
        $availableItem = Item::factory()->create(['status' => 'available']);

        $response = $this->actingAs($this->adminUser)
            ->patch(route('inventory.items.toggle-status', $availableItem));

        $this->assertDatabaseHas('items', [
            'id' => $availableItem->id,
            'status' => 'unavailable',
        ]);

        $response->assertRedirect(route('inventory.items.index'));
        $response->assertSessionHas('success');
    }

    #[Test]
    public function it_can_toggle_status_from_unavailable_to_available()
    {
        $unavailableItem = Item::factory()->create(['status' => 'unavailable']);

        $response = $this->actingAs($this->adminUser)
            ->patch(route('inventory.items.toggle-status', $unavailableItem));

        $this->assertDatabaseHas('items', [
            'id' => $unavailableItem->id,
            'status' => 'available',
        ]);

        $response->assertRedirect(route('inventory.items.index'));
    }

    #[Test]
    public function it_can_filter_items_by_status()
    {
        Item::factory()->count(3)->create(['status' => 'available']);
        Item::factory()->count(2)->create(['status' => 'unavailable']);

        $response = $this->actingAs($this->adminUser)
            ->get(route('inventory.items.index', ['status' => 'available']));

        $response->assertStatus(200);
        $response->assertViewHas('items');
    }

    #[Test]
    public function it_can_search_items()
    {
        Item::factory()->create(['name' => 'Widget A']);
        Item::factory()->create(['name' => 'Widget B']);
        Item::factory()->create(['name' => 'Gadget C']);

        $response = $this->actingAs($this->adminUser)
            ->get(route('inventory.items.index', ['search' => 'Widget']));

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_sort_items()
    {
        Item::factory()->count(5)->create();

        $response = $this->actingAs($this->adminUser)
            ->get(route('inventory.items.index', ['sort' => 'name']));

        $response->assertStatus(200);

        $response = $this->actingAs($this->adminUser)
            ->get(route('inventory.items.index', ['sort' => 'stock']));

        $response->assertStatus(200);

        $response = $this->actingAs($this->adminUser)
            ->get(route('inventory.items.index', ['sort' => 'oldest']));

        $response->assertStatus(200);
    }

    #[Test]
    public function it_validates_item_type_values()
    {
        $category = ItemCategory::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->post(route('inventory.items.store'), [
                'category_id' => $category->id,
                'item_code' => 'TYPE001',
                'name' => 'Test Item',
                'type' => 'invalid_type',
                'unit' => 'piece',
            ]);

        $response->assertSessionHasErrors('type');
    }

    #[Test]
    public function it_validates_minimum_stock_values()
    {
        $category = ItemCategory::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->post(route('inventory.items.store'), [
                'category_id' => $category->id,
                'item_code' => 'NEG001',
                'name' => 'Test Item',
                'type' => 'disposable',
                'unit' => 'piece',
                'current_stock' => -5,
                'min_stock' => -10,
            ]);

        $response->assertSessionHasErrors(['current_stock', 'min_stock']);
    }
}
