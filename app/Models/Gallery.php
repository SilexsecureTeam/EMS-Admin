<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected $appends = ['image1_url', 'image2_url', 'image3_url'];

    public function getImage1UrlAttribute()
    {
        return $this->image1 ? Storage::url($this->image1) : null;
    }

    public function getImage2UrlAttribute()
    {
        return $this->image2 ? Storage::url($this->image2) : null;
    }

    public function getImage3UrlAttribute()
    {
        return $this->image3 ? Storage::url($this->image3) : null;
    }
}
