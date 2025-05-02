<?php

namespace App\Http\Requests\Admin\Action;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->authenticate('update-action')) {
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
            'name' => ['required','string','max:255','unique:actions,name,'.$this->id],
            'module' => ['required','string','max:255'],
            'action' => ['required','string','max:255']
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
