<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['title', 'category_id', 'image', 'order_by', 'created_by'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
