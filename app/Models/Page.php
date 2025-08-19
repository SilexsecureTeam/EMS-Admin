<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_page',
        'sliders',
        'header_title',
        'header_description',
        'title_1',
        'content_1',
        'content_1_image',
        'title_2',
        'content_2',
        'content_2_image',
        'title_3',
        'content_3',
        'content_3_image',
        'title_4',
        'content_4',
        'content_4_image',
        'green_title',
        'green_description',
        'footer_title',
        'footer_contact',
        'footer_description',
    ];

    protected $casts = [
        'sliders' => 'array',
    ];
}
