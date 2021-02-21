<?php

namespace App\Http\Requests;

use App\Constants;
use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
{
    protected $redirect;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()->cannot(Constants::CREATE_CAMPAIGNS)) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:64|unique:campaigns,name',
            'prefix' => 'required|size:3',
            'coupon_amount' => 'required|numeric|min:1',
            'coupon_count' => 'required|integer|min:1',
            'coupon_validity' => 'required|integer|min:1',
            'limit_per_person' => 'required|integer|min:1',
            'starts_at' => 'required|dateformat:d/m/Y H:i',
            'ends_at' => 'nullable|dateformat:d/m/Y H:i',
        ];
    }
}
