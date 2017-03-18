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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filter($keyword, $status, $orderBy, $direction, $take)
    {
        $query = $this->orderBy($orderBy ?: 'created_at', $direction ?: 'desc');

        if ($keyword) {
            $query->where(function ($subQuery) use ($keyword) {
                $subQuery
                    ->where('name', 'like', "%$keyword%")
                    ->orwhereHas('user', function ($q1) use ($keyword) {
                        $q1->where('name', 'like', "%$keyword%");
                    })
                    ->orWhereHas('category', function ($q2) use ($keyword) {
                        $q2->where('name', 'like', "%$keyword%");
                    });
            });
        }

        if (isset($status)) {
            $query->where('status', $status);
        }

        return $query->paginate((isset($take) && $take > 0) ? $take :config('setting.front.product-page-limit'));
    }
}
