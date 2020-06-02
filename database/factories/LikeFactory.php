<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(
    Like::class,
    function (Faker $faker) {
        return [
            'user_id' => User::query()->orderBy('id', 'desc')->first(),
            'likable_id' => $faker->numberBetween(1, 50),
            'likable_type' => Post::class,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
);
