<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'description',
        'learning_outcomes',
        'course_fee',
        'target_audience',
        'entry_requirement',
        'curriculum',
        'course_content',
        'learning_experience'
    ];

    protected $casts = [
        'learning_outcomes' => 'array',
        'curriculum' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($program) {
            $program->slug = Str::slug($program->title);
        });

        static::updating(function ($program) {
            if ($program->isDirty('title')) {
                $program->slug = Str::slug($program->title);
            }
        });
    }

     protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function reviews()
    {
        return $this->hasMany(ProgramReview::class);
    }
}
