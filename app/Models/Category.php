<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'gender_id',
        'parent_id',
        'name',
        'slug',
    ];

    public function registerMediaCollections(): void {
        $this->addMediaCollection('category_image')
            ->singleFile();
    }

    public function gender() {
        return $this->belongsTo(Gender::class);
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(){
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'category_product');
    }
}
