<?php

namespace App\Enums;

class UserEnum
{
    public const STATUS_DELETED = -1;
    public const STATUS_DISABLE = 0;
    public const STATUS_ENABLE = 1;

    public static function getStatusName($status)
    {
        switch ($status) {
            case self::STATUS_DELETED:
                return '已删除';
                break;
            case self::STATUS_DISABLE:
                return '已禁用';
                break;
            case self::STATUS_ENABLE:
            default:
                return '已启用';
                break;
        }
    }
}
