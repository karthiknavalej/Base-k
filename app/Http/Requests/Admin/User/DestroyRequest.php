<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;

class DestroyRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->authenticate('destroy-user')) {
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
            'id'  => ['required','integer'],
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
