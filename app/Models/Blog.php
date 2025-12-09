<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'topic_id',
        'title',
        'subtitle',
        'slug',
        'content',
        'image',
        'is_active',
        'views',
        'meta_title',
        'meta_desc',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'views' => 'integer',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    /**
     * Get the topic
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('blog-images')
            ->singleFile();
    }
}
