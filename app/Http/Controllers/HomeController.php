<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $campaign = Campaign::where('active')->first();
        return view('home', compact('campaign'));
    }
}
