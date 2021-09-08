<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Helpers\Helper;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        //
        'name' => $name,
        'slug' => Helper::makeSlug($name),
    ];
});
