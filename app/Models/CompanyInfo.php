<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
     protected $fillable = [
        'address', 
        'phone_numbers', 
        'email'
    ];

    protected $casts = [
        'phone_numbers' => 'array',
    ];
}
