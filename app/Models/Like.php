<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('like.table_name');
    }

    protected static function boot()
    {
        parent::boot();

        self::saving(
            function ($like) {
                $foreign_key = config('like.foreign_key');
                $like->{$foreign_key} = $like->{$foreign_key} ?: auth()->user()->getKey();
            }
        );
    }

    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(config_path('auth.providers.users.model'), config('like.foreign_key'));
    }
}
