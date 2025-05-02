<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends BaseRequest
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
            'new_password' => ['required',
                                Password::min(8)->letters()->mixedCase()
                                ->numbers()->symbols()->uncompromised(),
                                'same:confirm_password'
                                ],
            'confirm_password' => ['required',
                                    Password::min(8)->letters()->mixedCase()
                                    ->numbers()->symbols()->uncompromised(),
                                  ],
            'token' => 'required',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            
        ];
    }
}
