<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Gender extends Model implements HasMedia {
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function registerMediaCollections(): void{
        $this->addMediaCollection('gender_image')
            ->singleFile();
    }

    public function clients() {
        return $this->hasMany(Client::class);
    }

    public function categories() {
        return $this->hasMany(Category::class);
    }
}
