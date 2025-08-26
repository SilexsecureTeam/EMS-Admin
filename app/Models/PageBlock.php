<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageBlock extends Model
{
     use HasFactory;

    protected $fillable = [
        'image',
        'header',
        'sub_heading',
        'title1',
        'content1',
        'title2',
        'content2',
        'title3',
        'content3',
    ];

}
