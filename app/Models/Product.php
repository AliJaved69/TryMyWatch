<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'thumbnail',
        'category',
        'brand',
        'rating',
        'gallery',
        'model_3d',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function getThumbnailAttribute($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        return $value ? asset('storage/' . $value) : null;
    }

    public function getGalleryAttribute($value)
    {
        $gallery = json_decode($value, true) ?? [];
        return array_map(function ($item) {
            if (filter_var($item, FILTER_VALIDATE_URL)) {
                return $item;
            }
            return asset('storage/' . $item);
        }, $gallery);
    }

    public function getModel3dAttribute($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        return $value ? '/storage/' . $value : null;
    }
}
