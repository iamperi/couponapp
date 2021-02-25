<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Dni;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
            'dni' => ['required', 'alpha_num', 'max:9', new Dni()],
            'phone' => 'required|max:9',
            'email' => 'required|email'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            if(User::where('phone', $this->phone)->where(function($query) {
                    $query->whereNull('dni')->orWhere('dni', '!=', $this->dni);
                })->exists()) {
                $validator->errors()->add('phone', __('validation.custom.phone.unique'));
            }
            if(User::where('email', $this->email)->where(function($query) {
                    $query->whereNull('dni')->orWhere('dni', '!=', $this->dni);
                })->exists()) {
                $validator->errors()->add('email', __('validation.custom.email.unique'));
            }
        });
    }
}
