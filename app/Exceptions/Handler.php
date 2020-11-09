<?php

namespace App\Exceptions;

use App\Helpers\ApiHelper;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

/**
 * Class Handler - 托管应用程序触发的所有异常
 *
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler
{
    use ApiHelper;
    /**
     * A list of the exception types that are not reported.
     * 无需报告的异常列表
     *
     * @var array
     */
    protected $dontReport = [
    ];
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     * 不会因异常而刷新的表单
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     * 报告或记录异常
     *
     * @param  Exception  $exception
     *
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     * 将异常渲染成一个 HTTP 响应
     *
     * @param  Request  $request
     * @param  Exception  $exception
     *
     * @return Response
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        if ($request->ajax()) {
            if ($response = $this->isJsonWebTokenException($exception)) {
                return $response;
            }

            if ($exception instanceof InvalidParameterException) {
                return $this->responseError(
                    $exception->getMessage() ?: get_class($exception),
                    $exception->getCode() ?: JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                    $exception->getTrace()
                );
            }

            if (app()->environment() === 'production') {
                return $this->responseError('线上环境未知错误，请联系相关人员进行修复');
            } else {
                return $this->responseError(
                    $exception->getMessage() ?: get_class($exception),
                    JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                    $exception->getTrace()
                );
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * 判断是否为 Json Web Token 引发的异常
     *
     * @param $exception
     *
     * @return JsonResponse|null
     */
    public function isJsonWebTokenException($exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            return $this->responseError('用户令牌无效', 401);
        }
        if ($exception->getPrevious() instanceof TokenBlacklistedException) {
            return $this->responseError('用户令牌弃用', 401);
        }
        if ($exception->getPrevious() instanceof TokenExpiredException) {
            return $this->responseError('用户令牌过期', 401);
        }
        if ($exception->getPrevious() instanceof TokenInvalidException) {
            return $this->responseError('令牌格式无效', 401);
        }

        return false;
    }
}
