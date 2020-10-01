<?php

namespace Formy\Tests\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;



class UnicornHeadFactory extends Factory {

    public function definition()
    {
        return [
            'title' => $this->faker->text(25)
        ];
    }

}
