<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    protected $fillable = [
        'title', 'category', 'description', 'activity_date', 
        'time_range', 'location', 'image', 'created_by', 'updated_by', 'meta_title', 'meta_description', 'meta_keyword', 'meta_image'
    ];

    // Auto-generate slug when title is set
    protected static function boot() {
        parent::boot();
        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title);
        });
    }
}
