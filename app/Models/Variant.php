<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Variant extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'barcode',
        'price',
        'sale_price',
        'meta_title',
        'meta_desc',
        'meta_keywords',
        'is_active',
    ];

    protected $casts = [
        'price' => 'float',
        'sale_price' => 'float',
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('variant_images');
    }

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->belongsToMany(Value::class, 'value_variant');
    }

    // Helper methods
    public function getDisplayPrice()
    {
        return $this->sale_price > 0 ? $this->sale_price : $this->price;
    }

    public function getVariantName()
    {
        $valueNames = $this->values->pluck('name')->toArray();
        return implode(' / ', $valueNames);
    }
}
