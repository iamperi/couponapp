<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class HistoricController extends Controller
{
    public function index()
    {
        $usedCoupons = Coupon::used()->get();
        return view('admin.historic.index', compact('usedCoupons'));
    }
}
