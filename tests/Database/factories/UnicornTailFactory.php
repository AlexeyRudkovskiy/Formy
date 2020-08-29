<?php

use Faker\Generator as Faker;
use Formy\Tests\Database\Models\UnicornTail;

$factory->define(UnicornTail::class, function (Faker $faker) {
    return [
        'name' => $faker->text(25),
        'unicorn_head_id' => 0
    ];
});
