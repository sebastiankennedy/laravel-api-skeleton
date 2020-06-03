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
            'user_id' => $faker->randomElement([49, 50, 51]),
            'likeable_id' => $faker->numberBetween(1, 3),
            'likeable_type' => Post::class,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
);
