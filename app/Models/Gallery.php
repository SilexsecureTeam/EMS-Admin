<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'gallery_header',
        'sub_header',
        'title',
        'image1',
        'image2',
        'image3',
    ];
}
