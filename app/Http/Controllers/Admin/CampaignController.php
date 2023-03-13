<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Models\Campaign;
use Carbon\Carbon;

class CampaignController extends Controller
{
    public function index()
    {
        $activeCampaigns = Campaign::notFinished()->get();
        $vipCode = Campaign::getVipCode();
        return view('admin.campaigns.index', compact('activeCampaigns', 'vipCode'));
    }

    public function store(StoreCampaignRequest $request)
    {
        $data = $request->validated();

        if(!array_key_exists('is_vip', $data)) $data['vip_code'] = null;

        Campaign::create($data);

        return redirect(route('admin.campaigns.index'))->with('success', __('Campaign created successfully'));
    }

    public function toggle(Campaign $campaign)
    {
        if(!auth()->user()->can(Constants::EDIT_CAMPAIGNS)) {
            abort(403);
        }

        if($campaign->active === false) {
            if(!$campaign->is_vip) {
                Campaign::deactivateActiveCampaign();
            } else {
                Campaign::deactivateActiveVipCampaign();
            }
        }

        $campaign->active = !$campaign->active;
        $campaign->save();

        return redirect(route('admin.campaigns.index'));
    }
}
