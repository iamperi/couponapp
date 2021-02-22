<?php

namespace App\Models;

use App\Constants;
use App\Filters\OrderBy;
use App\Filters\Search;
use App\Traits\HasCoupons;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pipeline\Pipeline;
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

    protected $appends = [
        'full_name'
    ];

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public static function shops()
    {
        return app(Pipeline::class)
            ->send(User::role(Constants::SHOP_ROLE))
            ->through([
                OrderBy::class,
                new Search(['username', 'email'])
            ])
            ->thenReturn()
            ->paginate(3);
    }

    public function getFullNameAttribute()
    {
        if($this->isShop()) {
            return $this->shop->name;
        } else {
            if(!empty($this->name)) {
                return $this->name . ' ' . $this->last_name;
            } else {
                return $this->username;
            }
        }
    }

    public function isShop()
    {
        return $this->hasRole(Constants::SHOP_ROLE);
    }

    public function isAdmin()
    {
        return $this->hasRole(Constants::ADMIN_ROLE);
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
