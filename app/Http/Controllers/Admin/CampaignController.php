<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Events\CampaignCreated;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function store()
    {
        if(auth()->user()->cannot(Constants::CREATE_CAMPAIGNS)) {
            abort(403);
        }

        $validated = request()->validate([
            'name' => 'required|max:64',
            'prefix' => 'required|size:3',
            'coupon_amount' => 'required|numeric|min:1',
            'coupon_count' => 'required|integer|min:1',
            'coupon_validity' => 'required|integer|min:0',
            'limit_per_person' => 'required|integer|min:0',
            'starts_at' => 'required|dateformat:d/m/Y H:i:s',
            'ends_at' => 'nullable|dateformat:d/m/Y H:i:s',
        ]);

        $campaign = Campaign::create($validated);

        if($campaign) {
            CampaignCreated::dispatch($campaign);
        }
    }
}
