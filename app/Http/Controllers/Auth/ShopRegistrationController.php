<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ShopRegistrationController extends Controller
{
    public function create()
    {
        $shop = Shop::where('registration_token', request('token'))->first();

        return view('auth.shops.register', compact('shop'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|exists:shops,registration_token',
            'shop_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'phone' => 'required|unique:users',
            'email' => 'nullable',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $shop = Shop::where('registration_token', request('token'))->first();

        $shop->user->username = request('username');
        $shop->user->phone = request('phone');
        $shop->user->password = Hash::make(request('password'));
        $shop->user->save();

        $shop->registration_token = NULL;
        $shop->save();

        Auth::login($shop->user);

        return redirect(route('admin.index'));
    }
}
