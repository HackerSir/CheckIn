<?php

namespace Database\Factories;

use App\Models\ClubType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubTypeFactory extends Factory
{
    protected $model = ClubType::class;

    public function definition(): array
    {
        return [
            'name'       => $this->faker->word,
            'color'      => $this->faker->hexColor,
            'is_counted' => $this->faker->boolean(),
        ];
    }
}
