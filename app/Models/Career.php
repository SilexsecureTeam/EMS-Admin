<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
         'title',
        'content',
        'placement_header',
        'email',
        'image'
    ];
}
