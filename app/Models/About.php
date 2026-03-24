<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = ['title', 'subtitle', 'description', 'image', 'mission', 'vision', 'values', 'meta_title', 'meta_description', 'meta_keywords'];
}
