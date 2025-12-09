<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category',
        'type',
        'key',
        'value',
        'details',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value by key
     */
    public static function set($key, $value, $category = 'general', $type = 'text')
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'category' => $category,
                'type' => $type,
            ]
        );
    }
}
