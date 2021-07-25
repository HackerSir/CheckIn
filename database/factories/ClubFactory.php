<?php

namespace Database\Factories;

use App\Models\Club;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubFactory extends Factory
{
    protected $model = Club::class;

    public function definition(): array
    {
        return [
            'number'      => $this->faker->optional()->regexify('[A-E]([0-9]){2}'),
            'name'        => $this->faker->word,
            'description' => $this->faker->sentence,
            'url'         => $this->faker->url,
        ];
    }
}
