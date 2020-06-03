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
        switch ($this->simpledRouteName) {
            default:
                return [];
                break;
        }
    }
}
