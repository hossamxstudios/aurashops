<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    /** @test */
    public function it_displays_brands_index_page()
    {
        Brand::factory()->count(3)->create();

        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.brands.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.brands.brands');
        $response->assertViewHas('brands');
    }

    /** @test */
    public function it_can_search_brands()
    {
        Brand::factory()->create(['name' => 'Nike']);
        Brand::factory()->create(['name' => 'Adidas']);

        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.brands.index', ['search' => 'Nike']));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_shows_create_form()
    {
        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.brands.create'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_store_a_new_brand()
    {
        Storage::fake('public');

        $data = [
            'name' => 'Test Brand',
            'slug' => 'test-brand',
            'details' => 'Brand details',
            'website' => 'https://example.com',
            'is_active' => true,
            'is_feature' => false,
        ];

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.brands.store'), $data);

        $response->assertRedirect(route('admin.brands.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('brands', [
            'name' => 'Test Brand',
            'slug' => 'test-brand',
            'website' => 'https://example.com',
        ]);
    }

    /** @test */
    public function it_validates_required_fields_when_storing()
    {
        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.brands.store'), []);

        $response->assertSessionHasErrors(['name', 'slug']);
    }

    /** @test */
    public function it_validates_unique_slug_when_storing()
    {
        Brand::factory()->create(['slug' => 'existing-slug']);

        $data = [
            'name' => 'New Brand',
            'slug' => 'existing-slug',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.brands.store'), $data);

        $response->assertSessionHasErrors('slug');
    }

    /** @test */
    public function it_validates_website_url_format()
    {
        $data = [
            'name' => 'Test Brand',
            'slug' => 'test-brand',
            'website' => 'not-a-valid-url',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.brands.store'), $data);

        $response->assertSessionHasErrors('website');
    }

    /** @test */
    public function it_shows_edit_form()
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.brands.edit', $brand));

        $response->assertStatus(200);
        $response->assertViewHas('brand');
    }

    /** @test */
    public function it_can_update_a_brand()
    {
        $brand = Brand::factory()->create();

        $data = [
            'name' => 'Updated Brand',
            'slug' => 'updated-brand',
            'details' => 'Updated details',
            'website' => 'https://updated.com',
            'is_active' => false,
            'is_feature' => true,
        ];

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.brands.update', $brand), $data);

        $response->assertRedirect(route('admin.brands.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('brands', [
            'id' => $brand->id,
            'name' => 'Updated Brand',
            'slug' => 'updated-brand',
            'is_feature' => true,
        ]);
    }

    /** @test */
    public function it_can_soft_delete_a_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.brands.destroy', $brand));

        $response->assertRedirect(route('admin.brands.index'));
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('brands', ['id' => $brand->id]);
    }

    /** @test */
    public function it_can_show_a_single_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.brands.show', $brand));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $brand->id,
            'name' => $brand->name,
        ]);
    }

    /** @test */
    public function it_can_bulk_delete_brands()
    {
        $brands = Brand::factory()->count(3)->create();

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.brands.bulk.delete'), [
                'ids' => $brands->pluck('id')->toArray(),
            ]);

        $response->assertRedirect(route('admin.brands.index'));
        $response->assertSessionHas('success');

        foreach ($brands as $brand) {
            $this->assertSoftDeleted('brands', ['id' => $brand->id]);
        }
    }

    /** @test */
    public function it_can_bulk_restore_brands()
    {
        $brands = Brand::factory()->count(3)->create();
        $brands->each->delete();

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.brands.bulk.restore'), [
                'ids' => $brands->pluck('id')->toArray(),
            ]);

        $response->assertRedirect(route('admin.brands.index'));
        $response->assertSessionHas('success');

        foreach ($brands as $brand) {
            $this->assertDatabaseHas('brands', [
                'id' => $brand->id,
                'deleted_at' => null,
            ]);
        }
    }

    /** @test */
    public function it_can_bulk_download_brands_as_csv()
    {
        Brand::factory()->count(3)->create();

        $response = $this->actingAs($this->admin, 'web')
            ->get(route('admin.brands.bulk.download', ['format' => 'csv']));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    /** @test */
    public function it_can_create_featured_brand()
    {
        $data = [
            'name' => 'Featured Brand',
            'slug' => 'featured-brand',
            'is_active' => true,
            'is_feature' => true,
        ];

        $response = $this->actingAs($this->admin, 'web')
            ->post(route('admin.brands.store'), $data);

        $response->assertRedirect(route('admin.brands.index'));

        $this->assertDatabaseHas('brands', [
            'name' => 'Featured Brand',
            'is_feature' => true,
        ]);
    }
}
