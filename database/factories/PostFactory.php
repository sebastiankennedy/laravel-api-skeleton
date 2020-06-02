<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(
    Post::class,
    function (Faker $faker) {
        return [
            'title' => $faker->title,
            'content' => $faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
);
