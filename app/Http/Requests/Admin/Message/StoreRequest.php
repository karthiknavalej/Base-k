<?php

namespace App\Http\Requests\Admin\Message;

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
            'message' => ['nullable','required_without:file','string','max:255'],
            'file' => 'required_without:message|file|mimes:jpeg,png,jpg,pdf,xlsx,xls,csv,bmp,doc,docx|max:5120',

        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
