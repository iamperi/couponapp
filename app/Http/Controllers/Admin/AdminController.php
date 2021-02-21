<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $shops = User::role(Constants::SHOP_ROLE)->get();
        $usedCoupons = Coupon::used()->get();
        $activeCampaigns = Campaign::active()->get();
        return view('admin.index', compact('shops', 'usedCoupons', 'activeCampaigns'));
    }
}
