<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActionRole;
use App\Models\Action;

class BaseRequest extends FormRequest
{
    /**
     * Http Status Code
     */
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;

    /**
    * Handle a failed validation attempt.
    *
    * @param  \Illuminate\Contracts\Validation\Validator  $validator
    *
    * @return void
    *
    * @throws HttpResponseException;
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                "success" => false,
                "code" => $this->code,
                "locale" => app()->getLocale(),
                "message" => $validator->errors(),
            ],
            $this->code
        ));
    }

    /**
    * Check authorization
    *
    * @method authenticate
    *
    * @param  string $action
    *
    * @return bool
    */
    protected function authenticate(string $action): bool
    {
        $auth = auth()->user();
        $roles = $auth->roles()->get();
        $roleNames = $roles->pluck('name')->toArray();
        // add roles to give access here
        if (!empty(array_intersect(['admin'], $roleNames))) {
            return true;
        }

        // // If not the above mentioned roles check for module level permission below
        $roleIds = $roles->pluck('id')->toArray();
        $actionIds = ActionRole::roles($roleIds)->pluck('action_id');
        $actions = Action::actions($actionIds)->pluck('slug');

        // Make Unique array
        $actions = collect($actions);
        $actions = $actions->unique()->toArray();

        // Check for special access
        $special = explode('-', $action);
        $special = 'all-'.end($special);
        
        // Check array exists
        if (in_array($action, $actions) || in_array($special, $actions)) {
            return true;
        }
        
        return false;
    }
}
