<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCouponRequest;
use App\Models\Campaign;
use App\Models\User;

class CouponController extends Controller
{
    public function assign(GetCouponRequest $request)
    {
        $user = User::getCitizen(request()->only(['name', 'last_name', 'dni', 'phone', 'email']));

        $campaign = Campaign::findOrFail(request('campaign_id'));

        $coupon = $user->assignCoupon($campaign);

        if(!$coupon) {

            return redirect()->back();
        }
    }
}
