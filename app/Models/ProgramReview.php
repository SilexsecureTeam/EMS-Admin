<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramReview extends Model
{
    protected $fillable = [
        'program_id',
        'reviewer_name',
        'review',
        'rating',
    ];

    public function programs()
    {
        return $this->belongsTo(Program::class);
    }
}
