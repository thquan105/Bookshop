<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [           
            'first_name' => ['required'],
            'last_name' => ['required'],
            'address1' => ['required'],
            'address2' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'postcode' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'string', 'max:255', Rule::unique('users')->ignore(Auth::user())],
        ];
    }
}
