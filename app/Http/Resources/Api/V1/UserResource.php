<?php

namespace App\Http\Resources\Api\V1;

use App\Enums\UserEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $user = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => UserEnum::getStatusName($this->status),
        ];

        $this->meta && $user['meta'] = $this->meta;

        return $user;
    }
}
