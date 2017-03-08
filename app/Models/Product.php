<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const PRODUCT_DEFAULT_IMAGE = 'public/images/default.jpg';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'image' => self::PRODUCT_DEFAULT_IMAGE,
    ];

    public function setImageAttribute($image)
    {
        $this->attributes['image'] = $image;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

}
