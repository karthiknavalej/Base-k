<?php

namespace App\Http\Requests\Admin\Role;

use App\Http\Requests\BaseRequest;

class ShowRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->authenticate('show-role')) {
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
