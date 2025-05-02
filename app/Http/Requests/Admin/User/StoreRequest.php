<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if (!$this->authenticate('store-user')) {
        //     return false;
        // }

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
            'name' => ['required','string','max:255','unique:users,name'],
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
