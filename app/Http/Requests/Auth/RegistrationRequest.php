<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends BaseRequest
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
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => [
                            'required',
                            Password::min(8)->letters()->mixedCase()
                            ->numbers()->symbols()->uncompromised(),
                            ],
            'role' => ['required','integer','exists:roles,id'],
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
