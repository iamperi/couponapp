<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Events\CampaignCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
        'coupon_amount' => 'double',
        'coupon_count' => 'integer',
        'coupon_validity' => 'integer',
        'limit_per_person' => 'integer',
        'is_vip' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => CampaignCreated::class
    ];

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function usedCoupons()
    {
        return $this->coupons()->whereNotNull('used_at')->whereNotNull('user_id')->get();
    }

    public function usedCouponCount()
    {
        return $this->usedCoupons()->count();
    }

    public function setPrefixAttribute($value)
    {
        $this->attributes['prefix'] = strtoupper($value);
    }

    public function setStartsAtAttribute($value)
    {
        $startsAt = $value;
        if(!empty($value) && !is_a($value, Carbon::class)) {
            $startsAt = Carbon::createFromFormat('d/m/Y H:i', $value);
        }
        $this->attributes['starts_at'] = $startsAt;
    }

    public function setEndsAtAttribute($value)
    {
        $endsAt = $value;
        if(!empty($value) && !is_a($value, Carbon::class)) {
            $endsAt = Carbon::createFromFormat('d/m/Y H:i', $value);
        }
        $this->attributes['ends_at'] = $endsAt;
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeNotFinished($query)
    {
        return $query->whereNull('ends_at')->orWhere('ends_at', '>=', Carbon::now());
    }

    public function isActive()
    {
        if(is_null($this->ends_at) || $this->ends_at >= Carbon::now()) {
            return true;
        }
        return false;
    }

    public function isStarted()
    {
        return $this->starts_at <= Carbon::now();
    }

    public function isEnded()
    {
        return !is_null($this->ends_at) && $this->ends_at < Carbon::now();
    }

    public function status()
    {
        return $this->active ? __('Active') : __('Inactive');
    }

    public static function deactivateActiveCampaign()
    {
        $campaign = self::active()->first();

        if($campaign) {
            $campaign->active = false;
            $campaign->save();
        }
    }

    public static function deactivateActiveVipCampaign()
    {
        $campaign = self::active()->where('is_vip', true)->first();

        if($campaign) {
            $campaign->active = false;
            $campaign->save();
        }
    }

    public function getNotStartedMessage()
    {
        return __('This campaign starts :date at :time', ['date' => $this->starts_at->locale('es')->isoFormat('D \d\e MMMM'), 'time' => $this->starts_at->format('H:i')]);
    }

    public static function getVipCode()
    {
        do {
            $code = Str::random(6);
        } while(Campaign::where('vip_code', $code)->exists());

        return strtoupper($code);
    }

    public function getUrl()
    {
        if($this->is_vip) return $this->getVipUrl();

        return route('home');
    }

    public function getVipUrl()
    {
        return config('app.url') . '/vip/' . $this->vip_code;
    }
}
