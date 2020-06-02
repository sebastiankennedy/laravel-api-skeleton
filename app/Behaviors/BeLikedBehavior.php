<?php

namespace App\Behaviors;

use Illuminate\Database\Eloquent\Model;

trait BeLikedBehavior
{
    public function isLikedBy(Model $model)
    {
        if (is_a($model, config('auth.providers.users.model'))) {
            if ($this->relationLoaded('likers')) {
                return $this->likers->contains($model);
            }

            if ($this->relationLoaded('likes')) {
                return $this->likes->where(config('like.foreign_key'), $model->getKey())->count() > 0;
            }

        }

        return false;
    }

    public function likes()
    {
        return $this->morphMany(config('like.model'), config('like.morph_many_name'));
    }

    public function likers()
    {
        return $this->belongsToMany(
            config('auth.providers.users.model'),
            config('like.table'),
            config('like.morph_many_name') . '_id',
            config('like.foreign_key')
        )
            ->where(config('like.morph_many_name') . '_type', $this->getMorphClass());
    }
}
