<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Notification - 消息通知模型
 *
 * @package App\Models
 */
class Notification extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'from_user_id',
        'to_user_id',
        'model_id',
        'model_type',
        'data',
        'read_at',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'model_id', 'model_type',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'read_at' => 'datetime',
    ];
}
