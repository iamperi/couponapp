<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Filters\OrderBy;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class ShopController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return User::shops();
        }
        $shopUsers = User::role(Constants::SHOP_ROLE)->get();
        return view('admin.shops.index', compact('shopUsers'));
    }

    public function store()
    {
        if(auth()->user()->cannot(Constants::CREATE_SHOPS)) {
            abort(403);
        }

        $validated = request()->validate([
            'name' => 'required|filled',
            'phone' => 'required|max:9|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|max:50|unique:users,username',
            'password' => 'required|confirmed'
        ]);

        $shopUser = User::create(request()->only([
            'phone', 'email', 'username', 'password'
        ]));

        $shopUser->assignRole(Constants::SHOP_ROLE);

        $shop = Shop::create([
            'user_id' => $shopUser->id,
            'name' => request('name')
        ]);

        $shop->user()->associate($shopUser);

        return redirect(route('admin.shops.index'))->with('success', __('Shop created successfully'));
    }
}
