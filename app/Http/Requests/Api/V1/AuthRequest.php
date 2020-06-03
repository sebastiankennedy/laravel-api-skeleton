<?php

namespace App\Http\Requests\Api\V1;

use App\Models\User;

class AuthRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->simpledRouteName) {
            case 'auth.register':
                return [
                    'name' => ['required', 'string'],
                    'email' => ['required', 'email', 'unique:' . User::TABLE_NAME],
                    'password' => ['required', 'string'],
                ];
                break;
            case 'auth.login':
                return [
                    'email' => ['required', 'email', 'exists:' . User::TABLE_NAME],
                    'password' => ['required', 'string'],
                ];
                break;
            default:
                return [];
        }
    }
}
