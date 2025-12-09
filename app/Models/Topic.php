<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Topic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'details',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($topic) {
            if (empty($topic->slug)) {
                $topic->slug = Str::slug($topic->name);
            }
        });
    }

    /**
     * Get all blogs for this topic
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
