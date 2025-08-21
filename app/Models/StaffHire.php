<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffHire extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'staff_category',
        'years_of_experience',
        'address',
        'city',
        'country',
        'zip_code',
        'interest_reason',
    ];
}
