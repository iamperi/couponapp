<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $shop = Shop::where('registration_token', request('registration_token'))->first();

        return view('auth.register', compact('shop'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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

        $shop = Shop::where('registration_token', $request->token)->first();

        Auth::login($user = User::create([
            'username' => $request->username,
            'email' => $request->email ?? $shop->user->email,
            'password' => Hash::make($request->password),
        ]));

        $shop->name = $request->shop_name;
        $shop->registration_token = NULL;
        $shop->save();

        event(new Registered($user));

        return redirect(route('admin.index'));
    }
}
