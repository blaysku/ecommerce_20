<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'level',
        'parent_id',
        'name',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function suggests()
    {
        return $this->hasMany(Suggest::class);
    }

    public function rootCategories()
    {
        return $this->whereParentId(config('setting.rootcategory'))->get();
    }

    public function getProductsThroughChildrens($id)
    {
        $category = Category::findOrFail($id);
        if (count($category->childrens)) {
            return Product::whereHas('category', function ($query) use ($id) {
                $query->whereHas('parent', function ($query) use ($id) {
                    $query->whereId($id);
                });
            });
        }
        return null;
    }
}
