<?php

namespace App\Models;

use App\Constants;
use App\Filters\OrderBy;
use App\Filters\Search;
use App\Mail\ShopRegistration;
use App\Notifications\ResetPasswordNotification;
use App\Traits\HasCoupons;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
                new Search(['shop.name', 'username', 'email', 'phone'])
            ])
            ->thenReturn()
            ->paginate(request('per_page') ?? 15);
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
            $username = Str::ascii(Str::snake($data['name'] . ' ' . $data['last_name']));
            $usernameCount = User::where('username', 'like', $username . '%')->count();
            if($usernameCount > 0) {
                $username .= '_' . ($usernameCount + 1);
            }
            $data['username'] = $username;
            $user = User::create($data);
        }
        return $user;
    }

    public function setNameAttribute($value)
    {
        if($value) {
            $this->attributes['name'] = ucwords(strtolower($value));
        }
    }

    public function setLastNameAttribute($value)
    {
        if($value) {
            $this->attributes['last_name'] = ucwords(strtolower($value));
        }
    }

    public function setDniAttribute($value)
    {
        $this->attributes['dni'] = strtoupper($value);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
