<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'brand_id',
        'gender_id',
        'sku',
        'barcode',
        'type',
        'name',
        'slug',
        'details',
        'rating',
        'base_price',
        'price',
        'sale_price',
        'views_count',
        'orders_count',
        'meta_title',
        'meta_desc',
        'meta_keywords',
        'is_active',
        'is_featured',
        'is_stockable',
    ];

    protected $casts = [
        'rating' => 'float',
        'base_price' => 'float',
        'price' => 'float',
        'sale_price' => 'float',
        'views_count' => 'integer',
        'orders_count' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_stockable' => 'boolean',
    ];

    protected $appends = ['image'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images');
        $this->addMediaCollection('product_thumbnail')
            ->singleFile();
    }

    // Accessors
    public function getImageAttribute()
    {
        $thumbnail = $this->getFirstMediaUrl('product_thumbnail');
        return $thumbnail ?: '/images/no-image.png';
    }

    // Relationships
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function subCategories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_product');
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

    public function bundleItems()
    {
        return $this->hasMany(BundleItem::class, 'parent_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Helper methods
    public function isSimple()
    {
        return $this->type === 'simple';
    }

    public function isVariant()
    {
        return $this->type === 'variant';
    }

    public function isBundle()
    {
        return $this->type === 'bundle';
    }

    public function getDisplayPrice()
    {
        // For both simple and variant products, return sale price if set, otherwise regular price
        return $this->sale_price > 0 ? $this->sale_price : $this->price;
    }
}
