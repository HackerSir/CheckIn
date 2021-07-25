<?php

namespace Database\Factories;

use App\Models\Booth;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoothFactory extends Factory
{
    protected $model = Booth::class;

    public function definition(): array
    {
        return [
            'name'      => $this->faker->regexify('[A-E]([0-9]){2}'),
            'longitude' => $this->faker->randomFloat(7, -180, 180),
            'latitude'  => $this->faker->randomFloat(7, -90, 90),
        ];
    }
}
