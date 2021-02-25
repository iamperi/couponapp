<?php

namespace App\Traits;

use App\Models\Coupon;
use Carbon\Carbon;

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

        if($coupon) {
            $assigned = $coupon->assignTo($this);

            return $assigned ? $coupon : NULL;
        } else {
            return NULL;
        }

    }

    public function couponsFor($campaign) {
        return Coupon::where([
            ['user_id', $this->id],
            ['campaign_id', $campaign->id],
        ])->count();
    }

    public function hasReachedCampaignLimit($campaign)
    {
        $limit = $campaign->limit_per_person;

        $userCoupons = $this->coupons()->where('campaign_id', $campaign->id)->count();

        return $userCoupons == $limit;
    }
}
