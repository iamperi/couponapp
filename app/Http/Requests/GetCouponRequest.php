<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->dni = str_replace(' ', '', $this->dni);
        $this->phone = str_replace(' ', '', $this->phone);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'campaign_id' => 'exists:campaigns,id',
            'name' => 'required',
            'last_name' => 'required',
            'dni' => 'required|max:9',
            'phone' => 'required|max:9',
            'email' => 'nullable|email'
        ];
    }
}
