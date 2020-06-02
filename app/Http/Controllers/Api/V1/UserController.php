<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\UserRequest;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\JsonResponse;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Api\V1
 */
class UserController extends Controller
{
    public function index(UserRequest $request)
    {

    }
    /**
     * @param  UserRequest  $request
     *
     * @return JsonResponse
     */
    public function me(UserRequest $request)
    {
        return $this->responseSuccess(new UserResource($request->user()));
    }
}
