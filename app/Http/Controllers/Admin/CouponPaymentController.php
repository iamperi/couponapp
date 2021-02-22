<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Models\Coupon;

class CouponPaymentController extends Controller
{
    public function update(Coupon $coupon)
    {
        if(!auth()->user()->can(Constants::PAY_COUPONS)) {
            abort(403);
        }

        if(!$coupon->payed_at) {
            $coupon->pay();
        } else {
            $coupon->unpay();
        }

        return redirect()->back();
    }
}
