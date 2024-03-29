<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Filters\OrderBy;
use App\Http\Controllers\Controller;
use App\Mail\ShopRegistration;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            $shopUsers = User::shops();

            return view('admin.shops.table', compact('shopUsers'));
        }
        $shopUsers = User::role(Constants::SHOP_ROLE)->paginate(25);
        return view('admin.shops.index', compact('shopUsers'));
    }

    public function store()
    {
        if(auth()->user()->cannot(Constants::CREATE_SHOPS)) {
            abort(403);
        }

        $validated = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
//            'phone' => 'required|max:9|unique:users,phone',
//            'username' => 'required|max:50|unique:users,username',
//            'password' => 'required|confirmed'
        ]);

        $shopUser = User::whereEmail(request('email'))->first();

        if(is_null($shopUser)) {
            $shopUser = User::create([
                'username' => request('email'),
                'email' => request('email')
            ]);
        }

        $shopUser->assignRole(Constants::SHOP_ROLE);

        $shop = Shop::whereId($shopUser->id)->first();

        if(is_null($shop)) {
            $shop = Shop::create([
                'user_id' => $shopUser->id,
                'name' => request('name')
            ]);

            $shop->generateRegistrationToken();

            $shop->user()->associate($shopUser);

            try {
                $shop->sendRegistrationEmail();
            } catch(\Exception $e) {
                return redirect(route('admin.shops.index'))->with('error', __('Error sending registration email'));
            }
        }

        return redirect(route('admin.shops.index'))->with('success', __('Shop created successfully'));
    }

    public function sendRegistrationEmail(Shop $shop)
    {
        try {
            $shop->resendRegistrationEmail();

            return redirect(route('admin.shops.index'))->with('success', __('Registration email forwarded correctly'));
        } catch(\Exception $e) {
            return redirect(route('admin.shops.index'))->with('error', __('Error sending registration email'));
        }
    }
}
