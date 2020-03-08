<?php

namespace App\Http\Middleware;

use App\Helpers\ApiHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JsonWebTokenMiddleware extends BaseMiddleware
{
    use ApiHelper;

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     * @throws JWTException
     */
    public function handle($request, Closure $next)
    {
        try {
            $this->checkForToken($request);
            if ($this->auth->parseToken()->authenticate()) {
                return $next($request);
            }
            throw new UnauthorizedHttpException('jwt-auth', '用户信息失效');
        } catch (UnauthorizedHttpException $exception) {
            return $this->responseError('需要用户令牌', 401);
        } catch (TokenBlacklistedException $exception) {
            return $this->responseError('令牌拉黑无效', 401);
        } catch (TokenInvalidException $exception) {
            return $this->responseError('令牌格式无效', 401);
        } catch (TokenExpiredException $exception) {
            return $this->responseError('用户令牌过期', 401);
        }
    }
}
