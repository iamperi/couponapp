<?php

namespace App\Models;

use App\Traits\HasCoupons;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasCoupons;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function getFullNameAttribute()
    {
        if(!empty($this->name)) {
            return $this->name . ' ' . $this->last_name;
        } else {
            return $this->username;
        }
    }

    public static function getCitizen($data)
    {
        $user = User::where('dni', $data['dni'])->first();
        if(!$user) {
            $data['username'] = $data['email'];
            $user = User::create($data);
        }
        return $user;
    }
}
