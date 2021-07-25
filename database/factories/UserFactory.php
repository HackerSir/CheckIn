<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {

        return [
            'name'           => $this->faker->name,
            'email'          => $this->faker->unique()->safeEmail,
            'password'       => bcrypt('secret'),
            'remember_token' => str_random(10),
        ];
    }

    public function isStudent(): UserFactory
    {
        return $this->state(function (array $attributes) {
            $isTeacher = $this->faker->boolean();
            $nid = $isTeacher
                ? $this->faker->regexify('[DEPMV]([0-9]){7}')
                : $this->faker->regexify('T[0-9]{5}');
            return [
                'nid' => $nid,
            ];
        });
    }
}
