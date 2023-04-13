<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_admin ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'street_address' => 'string',
            'city' => 'string',
            'state' => 'string',
            'postal_code' => 'string',
            'agent_license_number' => 'required|string',
            'contact_number' => 'required|string',
            'password' => 'string',
            // user system checkers
            'is_suspended' => 'boolean',
            'is_login' => 'boolean',
            'is_approve' => 'boolean',
            'is_agent' => 'boolean',
            'is_admin' => 'boolean',
            'has_system_access' => 'boolean'
        ];
    }
}
