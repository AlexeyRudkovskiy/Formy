<?php

namespace Formy\Tests\Database\factories;

use Faker\Generator as Faker;
use Formy\Tests\Database\Models\UnicornTail;

use Illuminate\Database\Eloquent\Factories\Factory;

class UnicornTailFactory extends Factory {

    public function definition()
    {
        return [
            'name' => $this->faker->text(25),
            'unicorn_head_id' => \Formy\Tests\Database\Models\UnicornHead::factory()
        ];
    }

}
