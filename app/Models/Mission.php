<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    
    protected $fillable = ['subtitle', 'title', 'description', 'icon', 'serial', 'status'];
}
