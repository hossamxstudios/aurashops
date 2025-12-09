<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    /** @test */
    public function it_displays_categories_index_page()
    {
        Category::factory()->count(3)->create();

        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.categories.categories');
        $response->assertViewHas('categories');
    }

    /** @test */
    public function it_can_search_categories()
    {
        Category::factory()->create(['name' => 'Electronics']);
        Category::factory()->create(['name' => 'Clothing']);

        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.categories.index', ['search' => 'Electronics']));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_shows_create_form()
    {
        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.categories.create'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_store_a_new_category()
    {
        Storage::fake('public');

        $data = [
            'name' => 'Test Category',
            'slug' => 'test-category',
            'details' => 'Category details',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.categories.store'), $data);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);
    }

    /** @test */
    public function it_validates_required_fields_when_storing()
    {
        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.categories.store'), []);

        $response->assertSessionHasErrors(['name', 'slug']);
    }

    /** @test */
    public function it_validates_unique_slug_when_storing()
    {
        Category::factory()->create(['slug' => 'existing-slug']);

        $data = [
            'name' => 'New Category',
            'slug' => 'existing-slug',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.categories.store'), $data);

        $response->assertSessionHasErrors('slug');
    }

    /** @test */
    public function it_shows_edit_form()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.categories.edit', $category));

        $response->assertStatus(200);
        $response->assertViewHas('category');
    }

    /** @test */
    public function it_can_update_a_category()
    {
        $category = Category::factory()->create();

        $data = [
            'name' => 'Updated Category',
            'slug' => 'updated-category',
            'details' => 'Updated details',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.categories.update', $category), $data);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Category',
            'slug' => 'updated-category',
        ]);
    }

    /** @test */
    public function it_can_soft_delete_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('categories', ['id' => $category->id]);
    }

    /** @test */
    public function it_can_show_a_single_category()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.categories.show', $category));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $category->id,
            'name' => $category->name,
        ]);
    }

    /** @test */
    public function it_can_bulk_delete_categories()
    {
        $categories = Category::factory()->count(3)->create();

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.categories.bulk.delete'), [
                'ids' => $categories->pluck('id')->toArray(),
            ]);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');

        foreach ($categories as $category) {
            $this->assertSoftDeleted('categories', ['id' => $category->id]);
        }
    }

    /** @test */
    public function it_can_bulk_restore_categories()
    {
        $categories = Category::factory()->count(3)->create();
        $categories->each->delete();

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.categories.bulk.restore'), [
                'ids' => $categories->pluck('id')->toArray(),
            ]);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');

        foreach ($categories as $category) {
            $this->assertDatabaseHas('categories', [
                'id' => $category->id,
                'deleted_at' => null,
            ]);
        }
    }

    /** @test */
    public function it_can_bulk_download_categories_as_csv()
    {
        Category::factory()->count(3)->create();

        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.categories.bulk.download', ['format' => 'csv']));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    /** @test */
    public function it_can_create_category_with_parent()
    {
        $parent = Category::factory()->create();

        $data = [
            'parent_id' => $parent->id,
            'name' => 'Child Category',
            'slug' => 'child-category',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.categories.store'), $data);

        $response->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'parent_id' => $parent->id,
            'name' => 'Child Category',
        ]);
    }
}
