<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BundleItem extends Model{

    protected $fillable = [
        'parent_id',
        'child_id',
        'type',
        'qty',
    ];

    protected $casts = [
        'qty' => 'integer',
    ];

    // Parent bundle product
    public function parent(){
        return $this->belongsTo(Product::class, 'parent_id');
    }

    // Alias for parent (bundle product)
    public function bundle(){
        return $this->belongsTo(Product::class, 'parent_id');
    }

    // Child product (for simple type)
    public function child(){
        return $this->belongsTo(Product::class, 'child_id');
    }

    // Variant options (for variant type)
    public function options(){
        return $this->hasMany(BundleItemOption::class);
    }

    // Get all available variants for this bundle item
    public function variants(){
        return $this->hasManyThrough(
            Variant::class,
            BundleItemOption::class,
            'bundle_item_id', // Foreign key on bundle_item_options
            'id',             // Foreign key on variants
            'id',             // Local key on bundle_items
            'variant_id'      // Local key on bundle_item_options
        );
    }
}
