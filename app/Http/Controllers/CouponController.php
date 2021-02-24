<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCouponRequest;
use App\Models\Campaign;
use App\Models\Coupon;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;

class CouponController extends Controller
{

    public function assign(GetCouponRequest $request)
    {
        $user = User::getCitizen(request()->only(['name', 'last_name', 'dni', 'phone', 'email']));

        $campaign = Campaign::findOrFail(request('campaign_id'));

        if($user->hasReachedCampaignLimit($campaign)) {
            return redirect()->back()->with('error', __('You have reached the coupon limit for this campaign'));
        }

        $coupon = $user->assignCoupon($campaign);

        return redirect(route('home'))->with('couponId', $coupon->id);
    }

    public function downloadPdf(Coupon $coupon)
    {
//        return view('coupon', compact('coupon'));
        $pdf = PDF::loadView('coupon', compact('coupon'));

        return $pdf->download('cupon.pdf');
    }
}
