<?php

namespace App\Models;

use App\Events\CampaignCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['starts_at', 'ends_at'];

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
        return $query->whereNull('ends_at')->orWhere('ends_at', '>=', Carbon::now());
    }

    public function isActive()
    {
        if(is_null($this->ends_at) || $this->ends_at >= Carbon::now()) {
            return true;
        }
        return false;
    }
}
