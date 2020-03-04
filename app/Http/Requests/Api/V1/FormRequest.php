<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseRequest;
use Illuminate\Http\Request;
use Route;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class FormRequest extends BaseRequest
{
    /**
     * 当前请求路由名称
     *
     * @var string
     */
    public $currentRouteName;
    /**
     * 当前接口版本
     *
     * @var
     */
    public $currentVersion;

    /**
     * FormRequest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->currentVersion = 'api.vi.';
        $this->currentRouteName = $this->currentVersion.Route::currentRouteName();
    }

    /**
     * Determine if the user is authorized to make this request.
     * 确定用户是否有权发出当前请求
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 返回当前请求的规则字段
     *
     * @return array
     */
    public function validatedFields()
    {
        return array_keys($this->rules());
    }

    /**
     * 返回当前请求的参数
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->only($this->validatedFields());
    }

    /**
     * 自定义表单验证报错信息格式
     *
     * @param  Validator  $validator
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->container['request'] instanceof Request) {
            throw new InvalidParameterException($validator->errors()->first(), 422);
        }
    }
}
