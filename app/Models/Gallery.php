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
        'image4',
        'image5',
        'image6',
        'image7',
        'image8',
        'image9',
        'image10',
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
    public function getImage4UrlAttribute()
    {
        return $this->image4 ? Storage::url($this->image4) : null;
    }
    public function getImage5UrlAttribute()
    {
        return $this->image5 ? Storage::url($this->image5) : null;
    }
    public function getImage6UrlAttribute()
    {
        return $this->image6 ? Storage::url($this->image6) : null;
    }
    public function getImage7UrlAttribute()
    {
        return $this->image7 ? Storage::url($this->image7) : null;
    }
    public function getImage8UrlAttribute()
    {
        return $this->image8 ? Storage::url($this->image8) : null;
    }
    public function getImage9UrlAttribute()
    {
        return $this->image9 ? Storage::url($this->image9) : null;
    }
    public function getImage10UrlAttribute()
    {
        return $this->image10 ? Storage::url($this->image10) : null;
    }
}
