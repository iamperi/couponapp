<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $campaign = Campaign::where('active', true)->first();
        try {
            $coupon = Coupon::find(session('couponId'));
        } catch(\Exception $e) {}

        return view('home', compact('campaign', 'coupon'));
    }
}
