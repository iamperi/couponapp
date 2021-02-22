<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Models\Campaign;
use Carbon\Carbon;

class CampaignController extends Controller
{
    public function store(StoreCampaignRequest $request)
    {
        Campaign::create($request->validated());

        return redirect()->back();
    }

    public function toggle(Campaign $campaign)
    {
        if(!auth()->user()->can(Constants::EDIT_CAMPAIGNS)) {
            abort(403);
        }

        $campaign->active = !$campaign->active;
        $campaign->save();

        return redirect(route('admin.index'));
    }
}
