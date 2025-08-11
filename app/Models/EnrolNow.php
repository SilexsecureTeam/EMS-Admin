<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrolNow extends Model
{
    protected $fillable = [
        'header_image',
        'title',
        'content',
        'pdf_file',
    ];
}
