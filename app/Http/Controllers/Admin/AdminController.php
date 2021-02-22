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
        $redirectTo = route('admin.shops.index');
        if(auth()->user()->hasRole(Constants::SHOP_ROLE)) {
            $redirectTo = route('admin.coupons.validation.index');
        }
        return redirect($redirectTo);
    }
}
