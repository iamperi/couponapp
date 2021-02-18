<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function store()
    {
        if(auth()->user()->cannot(Constants::CREATE_SHOPS)) {
            abort(403);
        }

        $validated = request()->validate([
            'name' => 'required|filled',
            'phone' => 'required|max:9',
            'email' => 'required|email',
            'username' => 'required|max:50',
            'password' => 'required|confirmed'
        ]);

        $shop = User::create($validated);

        $shop->assignRole(Constants::SHOP_ROLE);
    }
}
