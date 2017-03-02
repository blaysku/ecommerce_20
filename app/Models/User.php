<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const USER_DEFAULT_AVATAR = 'public/avatars/default.jpg';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'avatar' => self::USER_DEFAULT_AVATAR,
    ];

    public function setAvatarAttribute($avatar)
    {
        $this->attributes['avatar'] = $avatar;
    }

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = bcrypt($pass);
    }

    public function suggests()
    {
        return $this->hasMany(Suggest::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getUserByConfirmationCode($confirmationCode)
    {
        return $this->whereConfirmationCode($confirmationCode)->first();
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function countUser()
    {
        $counts = [
            'total' => $this->count(),
            config('setting.admin') => $this->whereIsAdmin(config('setting.admin_permission'))->count(),
        ];

        return $counts;
    }

    public function getUserByRole($role = null, $n = null)
    {
        $query = $this->oldest('status')->latest();

        if ($role == config('setting.admin')) {
            $query->whereIsAdmin(config('setting.admin_permission'));
        }

        return $query->paginate($n ? $n : config('setting.pagination_limit'));
    }
}
