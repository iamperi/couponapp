<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCouponRequest;
use App\Mail\CouponRequested;
use App\Models\Campaign;
use App\Models\Coupon;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;

class CouponController extends Controller
{
    public function assign(GetCouponRequest $request)
    {
        $user = NULL;
        try {
            $user = User::getCitizen(request()->only(['name', 'last_name', 'dni', 'phone', 'email']));
        } catch(\Exception $e) {
            logger()->info($e);
            return redirect(route('home'))->with('error', __('Sorry... We could not get you a coupon, try again later'));
        }

        $campaign = Campaign::findOrFail(request('campaign_id'));

        if($user->hasReachedCampaignLimit($campaign)) {
            return redirect()->back()->with('error', __('You have reached the coupon limit for this campaign'));
        } else if($campaign->isEnded()) {
            return redirect()->back()->with('error', __('Sorry... This campaign has ended'));
        }

        $coupon = $user->assignCoupon($campaign);

        if($coupon) {
            try {
                PDF::loadView('coupon', compact('coupon'))
                    ->save($coupon->getPdfPath());

                Mail::to($user)->send(new CouponRequested($coupon, $user));

                unlink($coupon->getPdfPath());

                return redirect(route('home'))->with('couponId', $coupon->id);
            } catch(\Exception $e) {
                if($coupon) {
                    $coupon->unassign();
                }
                logger()->info($e);
                return redirect(route('home'))->with('error', __('Sorry... We could not get you a coupon, try again later'));
            }
        }

        return redirect(route('home'))->with('error', __('Sorry... There are no coupons left for this campaign'));
    }

    public function downloadPdf(Coupon $coupon)
    {
//        return view('coupon', compact('coupon'));
        $pdf = PDF::loadView('coupon', compact('coupon'));

        return $pdf->download('tu-cupon.pdf');
    }
}
