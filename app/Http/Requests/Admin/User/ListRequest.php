<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;

class ListRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if (!$this->authenticate('list-user')) {
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
            
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
