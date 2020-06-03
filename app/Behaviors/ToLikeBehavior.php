<?php

namespace App\Behaviors;

use Illuminate\Database\Eloquent\Model;

trait ToLikeBehavior
{
    public function hasLiked(Model $model)
    {
        if ($this->relationLoaded('likes')) {
            return $this->likes
                    ->where(config('like.morph_many_id'), $model->getKey())
                    ->where(config('like.morph_many_type'), $model->getMorphClass())
                    ->count() > 0;
        }

        $like_model_name = config('like.model');
        $like_model = new $like_model_name();

        return $like_model::query()
                ->where(config('like.foreign_key'), $this->getKey())
                ->where(config('like.morph_many_id'), $model->getKey())
                ->where(config('like.morph_many_type'), $model->getMorphClass())
                ->count() > 0;
    }

    public function likes()
    {
        return $this->hasMany(config('like.model'), config('like.foreign_key'), $this->getKeyName());
    }
}
