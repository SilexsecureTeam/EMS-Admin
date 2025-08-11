<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'author_id',
        'status',
        'top_stories'
    ];

    protected static function booted()
    {
        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title);
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
