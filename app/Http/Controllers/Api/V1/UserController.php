<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\JwtHelper;
use App\Http\Requests\Api\V1\UserRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use DB;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Api\V1
 */
class UserController extends Controller
{
    /**
     * @param  UserRequest  $request
     *
     * @return JsonResponse
     */
    public function list(UserRequest $request)
    {
        $users = User::query()
            ->where('name', 'like', '%'.$request->name.'%')
            ->where('email', 'like', '%'.$request->email.'%')
            ->latest('id')
            ->limit(10)
            ->get();

        return $this->responseSuccess(UserResource::collection($users));
    }

    /**
     * @param  UserRequest  $request
     *
     * @return JsonResponse
     */
    public function show(UserRequest $request)
    {
        $user = User::find($request->id);

        return $this->responseSuccess(new UserResource($user));
    }

    /**
     * @param  UserRequest  $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function register(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $meta = JwtHelper::generateMeta($user);
        $user->meta = $meta;
        $user->sendEmailVerificationNotification();

        return $this->responseSuccess(new UserResource($user));
    }

    /**
     * @param  UserRequest  $request
     *
     * @return JsonResponse
     */
    public function login(UserRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $token = auth()->attempt($credentials);
        if (!$token) {
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
     * @param  UserRequest  $request
     *
     * @return JsonResponse
     */
    public function me(UserRequest $request)
    {
        return $this->responseSuccess(new UserResource(auth()->user()));
    }

    public function verifiy(UserRequest $request)
    {

    }
}
