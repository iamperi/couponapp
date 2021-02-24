<?php

namespace App\Models;

use App\Constants;
use App\Filters\OrderBy;
use App\Filters\Search;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['payed_at', 'used_at', 'expires_at'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function assignTo($user)
    {
        $this->user()->associate($user)->save();

        $this->expires_at = Carbon::now()->addHours($this->campaign->coupon_validity);

        $this->save();
    }

    public function verify()
    {
        if(!$this->assigned()) {
            return [false, __('Coupon is not assigned to any user')];
        } else if($this->redeemed()) {
            return [false, __('Coupon is already used')];
        } else if($this->expired()) {
            return [false, __('Coupon is expired')];
        } else {
            return [true, __('Coupon is valid')];
        }
    }

    public function validate()
    {
        try {
            if(!$this->isValid()) {
                return false;
            }
            $this->shop()->associate(auth()->user()->shop);
            $this->used_at = Carbon::now();
            $this->save();

            $this->shop->unpayed($this->amount);

            return true;
        } catch(\Exception $e) {
            return __('Ooops... Something bad happened');
        }
    }

    public function assigned()
    {
        return !is_null($this->user);
    }

    public function redeemed()
    {
        return !is_null($this->used_at);
    }

    public function expired()
    {
        return !is_null($this->expires_at) && $this->expires_at < Carbon::now();
    }

    public function isValid()
    {
        return $this->assigned()
            && !$this->redeemed()
            && !$this->expired();
    }

    public function pay()
    {
        if(!$this->redeemed()) {
            return;
        }

        $this->payed_at = Carbon::now();
        $this->save();

        $this->shop->payed($this->amount);
    }

    public function unpay()
    {
        $this->payed_at = NULL;
        $this->save();

        $this->shop->unpayed($this->amount);
    }

    public function payedStatus()
    {
        return $this->payed_at ? __('Payed') : __('Unpayed');
    }

    public static function newCode($prefix)
    {
        $codeExists = false;
        $newCode = generateCode($prefix);
        do {
            if(Coupon::where('code', $newCode)->exists()) {
                $codeExists = true;
                $newCode = generateCode($prefix);
            } else {
                $codeExists = false;
            }
        } while($codeExists);
        return $newCode;
    }

    public static function for($campaign)
    {
        return static::where([
            ['campaign_id', $campaign->id],
            ['used_at', NULL],
            ['user_id', NULL]
        ])->get()->random();
    }

    public static function filterUsed()
    {
        $query = Coupon::whereNotNull('used_at')->join('users', 'coupons.user_id', '=', 'users.id');
        if(auth()->user()->hasRole(Constants::SHOP_ROLE)) {
            $query = $query->where('shop_id', auth()->user()->id);
        }
        return app(Pipeline::class)
            ->send($query)
            ->through([
                OrderBy::class,
                new Search(['code']),
                \App\Filters\Shop::class,
                \App\Filters\Campaign::class
            ])
            ->thenReturn()
            ->paginate(request('per_page') ?? 15);
    }

    public function scopeUsed($query)
    {
        return $query->whereNotNull('used_at');
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
}
