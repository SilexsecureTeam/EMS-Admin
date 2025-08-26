<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramReview extends Model
{
    protected $fillable = [
        'reviewer_name',
        'review',
        'rating',
        'image',
        'featured',
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];
}

