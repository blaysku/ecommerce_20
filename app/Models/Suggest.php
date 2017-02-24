<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggest extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
