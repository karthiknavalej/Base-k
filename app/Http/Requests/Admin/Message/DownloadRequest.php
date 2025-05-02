<?php

namespace App\Http\Requests\Admin\Message;

use App\Http\Requests\BaseRequest;

class DownloadRequest extends BaseRequest
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
            'id'  => ['required','integer', 'exists:messages,id'],
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
