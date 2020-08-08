<?php

namespace App\Models;

use App\Notifications\EmailVerification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use Notifiable;
    public const TABLE_NAME = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'remember_token',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 判断用户是否已验证其电子邮件地址
     *
     * @return bool|void
     */
    public function hasVerifiedEmail()
    {
        return !$this->email_verified_at ?? $this->email;
    }

    /**
     * 将当前用户电子邮件标记为已验证
     *
     * @return bool|void
     */
    public function markEmailAsVerified()
    {
        return $this->update(['email_verified_at' => now()]);
    }

    /**
     * 发送电子邮件验证通知
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerification());
    }

    /**
     * 获取用于验证的电子邮件地址
     *
     * @return string|void
     */
    public function getEmailForVerification()
    {
    }

    /**
     * 定义 payload 中 sub 字段返回内容
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 在 payload 中增加自定义内容
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
