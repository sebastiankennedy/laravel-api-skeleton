<?php

namespace App\Behaviors;

use Illuminate\Database\Eloquent\Model;

trait BeLikedBehavior
{
    public function isLikedBy(Model $user)
    {
        if (is_a($user, config('auth.providers.users.model'))) {
            if ($this->relationLoaded('likers')) {
                return $this->likers->contains($user);
            }

            if ($this->relationLoaded('likes')) {
                return $this->likes->where(config('like.foreign_key'), $user->getKey())->count() > 0;
            }

            $like_model_name = config('like.model');
            $like_model = new $like_model_name();

            return $like_model::query()
                    ->where(config('like.morph_many_id'), $this->getKey())
                    ->where(config('like.morph_many_type'), $this->getMorphClass())
                    ->where(config('like.foreign_key'), $user->getKey())
                    ->count() > 0;
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
            config('like.table_name'),
            config('like.morph_many_id'),
            config('like.foreign_key')
        )->where('likeable_type', $this->getMorphClass());
    }
}
