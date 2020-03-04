<?php

namespace App\Helpers;

use App\Models\User;
use JWTAuth;

/**
 * Class JwtHelper
 *
 * @package App\Helpers
 */
class JwtHelper
{
    /**
     * @param $item
     *
     * @return mixed
     */
    public static function generateToken($item)
    {
        return $item instanceof User ? JWTAuth::fromUser($item) : $item;
    }

    /**
     * @return string
     */
    public static function generateExpireTime()
    {
        return now()->addMinutes(JWTAuth::factory()->getTTL())->toDateTimeString();
    }

    /**
     * @param $item
     *
     * @return array
     */
    public static function generateMeta($item)
    {
        return [
            'type' => 'Bearer',
            'token' => self::generateToken($item),
            'expired_at' => self::generateExpireTime(),
        ];
    }
}
