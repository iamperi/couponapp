<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function verify(Coupon $coupon)
    {
        if(!auth()->user()->can(Constants::VALIDATE_COUPONS)) {
            abort(403);
        }

        $validated = $coupon->validate();

        if(is_bool($validated) && $validated) {
            return [
                'status' => 'ok',
                'msg' => 'Todo correcto'
            ];
        } else {
            return [
                'status' => 'error',
                'msg' => $validated
            ];
        }
    }
}
