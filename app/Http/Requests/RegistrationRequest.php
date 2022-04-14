<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'regex:/^[a-ŽA-Ž. -]+$/', 'max:50'],
            'last_name' => ['required', 'regex:/^[a-ŽA-Ž. -]+$/', 'max:50'],
            'email' => ['required', 'email', 'max:100', 'unique:users', 'regex:/^[A-Ža-Ž0-9\.]*@(ferit|etfos).hr$/'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()]
        ];
    }
}
