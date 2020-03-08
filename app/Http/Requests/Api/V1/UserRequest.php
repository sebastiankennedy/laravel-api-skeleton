<?php

namespace App\Http\Requests\Api\V1;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->currentRouteName) {
            case 'user.list':
                return [
                    'name' => ['string'],
                    'email' => ['email'],
                ];
                break;
            case 'user.register':
                return [
                    'name' => ['required', 'string'],
                    'email' => ['required', 'email'],
                    'password' => ['required', 'string'],
                ];
                break;
            case 'user.login':
                return [
                    'email' => ['required', 'email', 'exists:users'],
                    'password' => ['required', 'string'],
                ];
                break;
            case 'user.show':
                return [
                    'id' => ['required', 'integer', 'exists:users'],
                ];
                break;
            case 'user.verify':
                return [
                    'token' => ['required', 'string'],
                ];
                break;
            default:
                return [];
                break;
        }
    }

    public function messages()
    {
        return [
            'email.exists' => 'The user does not exists',
        ];
    }
}
