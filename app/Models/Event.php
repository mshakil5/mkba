<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'status', 'image', 
        'event_date', 'start_time', 'end_time', 'location', 
        'description', 'meta_title', 'meta_description', 'meta_keywords',
        'created_by', 'updated_by', 'order_by'
    ];

    // Auto-generate slug when title is set
    protected static function boot() {
        parent::boot();
        static::creating(function ($event) {
            $event->slug = Str::slug($event->title);
        });
    }
}
