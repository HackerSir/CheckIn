<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        $isTeacher = $this->faker->boolean();
        $nid = $isTeacher
            ? $this->faker->regexify('[DEPMV]([0-9]){7}')
            : $this->faker->regexify('T[0-9]{5}');

        return [
            'nid'       => $nid,
            'name'      => $this->faker->name,
            'class'     => '資訊工程學系一年級丁班',
            'unit_name' => '資訊工程學系',
            'dept_name' => '資訊電機學院',
            'in_year'   => $this->faker->numberBetween(90, 106),
            'gender'    => $this->faker->randomElement(['M', 'F']),
        ];
    }
}
