<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
            'name' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'password' => ['nullable', 'string', 'confirmed', 'min:8'],
            'address1' => ['nullable'],
            'address2' => ['nullable'],
            'province_id' => ['nullable'],
            'city_id' => ['nullable'],
            'postcode' => ['nullable'],
            'phone' => ['nullable'],
            'email' => ['required', 'string', 'max:255', Rule::unique('users')->ignore(Auth::user())],
        ];
    }
}
