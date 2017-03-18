<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
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
                $subQuery->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");
                })
                ->orWhere('id', $keyword);
            });
        }

        if (isset($status)) {
            $query->where('status', $status);
        }

        return $query->paginate((isset($take) && $take > 0) ? $take :config('setting.front.product-page-limit'));
    }
}
