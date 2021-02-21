<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Events\CampaignCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    public function store(StoreCampaignRequest $request)
    {
        Campaign::create($request->validated());

        return redirect()->back();
    }
}
