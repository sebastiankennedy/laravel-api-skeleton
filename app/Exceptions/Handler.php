<?php

namespace App\Exceptions;

use App\Helpers\ApiHelper;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        // 处理 Ajax 请求异常
        if ($request->ajax()) {
            if (app()->environment() === 'production') {
                return $this->responseError('线上环境未知错误，请联系相关人员进行修复');
            } else {
                return $this->responseError($exception->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $exception->getTrace());
            }
        }

        return parent::render($request, $exception);
    }
}
