<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

/**
 * Trait ApiHelper
 *
 * @package App\Helpers
 */
trait ApiHelper
{
    /**
     * @var
     */
    protected $message;
    /**
     * @var
     */
    protected $httpCode;
    /**
     * @var
     */
    protected $statusCode;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @param $httpCode
     *
     * @return $this
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;

        return $this;
    }

    /**
     * @param $data
     *
     * @param $message
     * @param $statusCode
     * @param $httpCode
     *
     * @return JsonResponse
     */
    public function response($data, $message = '', $statusCode = 0, $httpCode = 200)
    {
        return response()->json([
            'status_code' => $this->statusCode ?: $statusCode,
            'message' => $this->message ?: $message,
            'data' => $data,
        ], $this->httpCode ?: $httpCode)
            ->header('Content-Type', 'application/json');
    }

    /**
     * @param $data
     * @param  string  $message
     * @param  int  $statusCode
     * @param  int  $httpCode
     *
     * @return JsonResponse
     */
    public function responseSuccess($data, $message = 'success', $statusCode = 0, $httpCode = JsonResponse::HTTP_OK)
    {
        return $this->response($data, $message, $statusCode, $httpCode);
    }

    /**
     * @param $statusCode
     * @param  string  $message
     * @param  array  $data
     * @param  int  $httpCode
     *
     * @return JsonResponse
     */
    public function responseError($message = 'error', $statusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR,  $data = [], $httpCode = JsonResponse::HTTP_OK)
    {
        return $this->response($data, $message, $statusCode, $httpCode);
    }
}
