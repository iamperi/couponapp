<?php

namespace App\Traits;

use App\Models\Coupon;

trait HasCoupons
{
    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function assignCoupon($campaign)
    {
        $assignedCoupons = $this->couponsFor($campaign);

        if($assignedCoupons >= $campaign->limit_per_person) {
            return false;
        }

        $coupon = Coupon::for($campaign);

        $coupon->user()->associate($this)->save();

        return $coupon;
    }

    public function couponsFor($campaign) {
        return Coupon::where([
            ['user_id', $this->id],
            ['campaign_id', $campaign->id],
        ])->count();
    }
}
