<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $fillable = ['label', 'title', 'description', 'order_by'];
}
