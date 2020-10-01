<?php

use Faker\Generator as Faker;
use Formy\Tests\Database\Models\UnicornHead;

$factory->define(UnicornHead::class, function (Faker $faker) {
    return [
        'title'     => $faker->text(25),
    ];
});
