<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Brand extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'details',
        'website',
    ];

    public function registerMediaCollections(): void {
        $this->addMediaCollection('brand_logo')->singleFile();
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'brand_category');
    }
}
