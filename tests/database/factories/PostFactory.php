<?php

namespace JohnDoe\BlogPackage\Database\Factories;

use Faker\Generator as Faker;
use JohnDoe\BlogPackage\Models\Post;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title'     => $faker->words(5),
    ];
});
