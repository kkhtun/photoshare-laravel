<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Helpers\Helper;
use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $caption = $faker->sentence(5);
    return [
        //
        //

        'slug' => Helper::makeSlug($caption),
        'user_id' => rand(1, 2),
        'caption' => $caption,
        'filename' => $faker->sentence,
    ];
});
