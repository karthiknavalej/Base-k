<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends BaseRequest
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
            'email' => ['required','string','email','max:255'],
            'password' => [
                'required',
                Password::min(8)->letters()->mixedCase()
                ->numbers()->symbols()->uncompromised(),
                ],
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
