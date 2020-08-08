<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\JwtHelper;
use App\Http\Requests\Api\V1\AuthRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Class AuthController - 用户认证控制器
 *
 * @package App\Http\Controllers\Api\V1
 */
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

    /**
     * @return mixed
     */
    public function refresh()
    {
        $user = auth()->user();
        if (!$user) {
            return $this->responseError('用户令牌无效', 401);
        }
        $token = JwtHelper::generateToken($user);
        $user->meta = JwtHelper::generateMeta($token);

        return $this->responseSuccess(new UserResource($user));
    }
}
