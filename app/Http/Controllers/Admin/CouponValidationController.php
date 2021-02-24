<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Models\Coupon;

class CouponValidationController extends Controller
{
    public function index()
    {
        try {
            $coupon = Coupon::find(session('couponId'));
        } catch(\Exception $e) {}
        return view('admin.coupons.validate', compact('coupon'));
    }

    public function store(Coupon $coupon)
    {
        if(!auth()->user()->can(Constants::VALIDATE_COUPONS)) {
            abort(403);
        }

        $validated = $coupon->validate();

        $response = $validated ? 'success' : 'error';
        $message = $validated ? __('Coupon has been validated') : __('An error ocurred while validating coupon');

        return redirect(route('admin.coupons.validation.index'))->with($response, $message);
    }
}
