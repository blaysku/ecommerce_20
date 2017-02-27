<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


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

    protected $defaultAvatar = 'avatar/default.jpg';

    public function __construct($attributes = [])
    {
        $this->setAvatarAttribute($this->defaultAvatar);
        parent::__construct($attributes);
    }

    /**
     * Set the user's avatar.
     *
     * @param    string  $value
     * @return  void
     */
    public function setAvatarAttribute($value)
    {
        $this->attributes['avatar'] = strtolower($value);
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

}
