<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Shop;
use Illuminate\Http\Request;

class HistoricController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            $usedCoupons = Coupon::filterUsed();

            return view('admin.historic.table', compact('usedCoupons'));
        }
        $usedCoupons = Coupon::used()->get();
        $shops = Shop::all();
        return view('admin.historic.index', compact('usedCoupons', 'shops'));
    }
}
