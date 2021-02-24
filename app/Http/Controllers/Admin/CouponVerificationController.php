<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponVerificationRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponVerificationController extends Controller
{
    public function verify(CouponVerificationRequest $request)
    {
        $coupon = Coupon::where('code', request('code'))->first();

        if(!$coupon) {
            return redirect()->back()->with('error', __('Coupon does not exist'))->withInput();
        } else {
            $result = $coupon->verify();

            $valid = $result[0];
            $message = $result[1];

            $response = $valid ? 'valid' : 'invalid';

            $flashData = [$response => $message];
            if($valid) { $flashData['couponId'] = $coupon->id; }

            return redirect(route('admin.coupons.validation.index'))->with($flashData)->withInput();
        }
    }
}
