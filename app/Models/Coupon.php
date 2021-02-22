<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['payed_at', 'used_at'];

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
    }

    public function validate()
    {
        try {
            if(!$this->assigned()) {
                return __('Coupon is not assigned to any user');
            } else if($this->redeemed()) {
                return __('Coupon is already used');
            } else if($this->expired()) {
                return __('Coupon is expired');
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
        return $this->expires_at < Carbon::now();
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

    public function scopeUsed($query)
    {
        return $query->whereNotNull('used_at');
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
}
