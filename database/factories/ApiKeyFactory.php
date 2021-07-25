<?php

namespace Database\Factories;

use App\Models\ApiKey;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApiKeyFactory extends Factory
{
    protected $model = ApiKey::class;

    public function definition(): array
    {
        $count = $this->faker->numberBetween(0, 25000);
        $totalCount = $count + $this->faker->numberBetween(0, 25000);

        return [
            'api_key'     => str_random(),
            'count'       => $count,
            'total_count' => $totalCount,
        ];
    }
}
