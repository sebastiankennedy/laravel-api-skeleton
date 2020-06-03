<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\JwtHelper;
use App\Http\Requests\Api\V1\AuthRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Throwable;

class AuthController extends Controller
{
    /**
     * @param  AuthRequest  $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function register(AuthRequest $request)
    {
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]
        );
        $meta = JwtHelper::generateMeta($user);
        $user->meta = $meta;
        $user->sendEmailVerificationNotification();

        return $this->responseSuccess(new UserResource($user));
    }

    /**
     * @param  AuthRequest  $request
     *
     * @return JsonResponse
     */
    public function login(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!$token = auth()->attempt($credentials)) {
            return $this->responseError('用户认证失败', 401);
        }

        $user = auth()->user();
        $meta = JwtHelper::generateMeta($token);
        $user->meta = $meta;

        return $this->responseSuccess(new UserResource($user));
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->responseSuccess([]);
    }
}
