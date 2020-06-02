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
            case 'users.index':
                return [
                    'name' => ['string'],
                    'email' => ['email'],
                ];
                break;
            case 'users.show':
                return [
                    'id' => ['required', 'integer', 'exists:users'],
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
