<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trustee extends Model
{
    protected $fillable = ['name', 'role', 'initials', 'bio', 'image',  'order_by', 'created_by', 'updated_by'];
}
