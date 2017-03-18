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
        return $this->belongsTo(OrderItem::class, 'id', 'product_id');
    }

    public function getProductWithFilter($keyword, $categories, $price, $orderBy, $direction)
    {
        $query = $this->select('id', 'name', 'image', 'price', 'avg_rating')->orderBy($orderBy ?: 'created_at', $direction ?: 'desc');

        if ($keyword) {
            $query->where(function ($subQuery) use ($keyword) {
                $subQuery->whereHas('category', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");
                })
                    ->orWhere('name', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%");
            });
        }

        if ($price) {
            $query->whereBetween('price', $price);
        }

        if ($categories) {
            $query->whereIn('category_id', $categories);
        }

        return $query->paginate(config('setting.front.product-page-limit'));
    }

    public function updateAvgRating()
    {
        $this->avg_rating = $this->ratings->avg('rating');
        $this->save();
        return $this->avg_rating;
    }
}
