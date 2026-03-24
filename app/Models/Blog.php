<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'author', 'post_date', 
        'summary', 'description', 'image', 'meta_title', 
        'meta_description', 'meta_keywords', 'status', 'created_by'
    ];

    // Auto-generate slug when title is set
    protected static function boot() {
        parent::boot();
        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title);
        });
    }
}
