<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'category',
        'image_url',
        'gallery_images',
        'location',
        'description',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'is_featured' => 'boolean',
    ];
}
