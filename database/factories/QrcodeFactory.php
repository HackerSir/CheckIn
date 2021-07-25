<?php

namespace Database\Factories;

use App\Models\Qrcode;
use Illuminate\Database\Eloquent\Factories\Factory;

class QrcodeFactory extends Factory
{
    protected $model = Qrcode::class;

    public function definition(): array
    {
        return [
            'code'    => $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'bind_at' => $this->faker->optional()->dateTime,
        ];
    }
}
