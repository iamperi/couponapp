<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $shops = User::role(Constants::SHOP_ROLE)->get();
        return view('admin.index', compact('shops'));
    }
}
