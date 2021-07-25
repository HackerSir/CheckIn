<?php

namespace Database\Factories;

use App\Models\ContactInformation;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactInformationFactory extends Factory
{
    protected $model = ContactInformation::class;

    public function definition(): array
    {
        $studentNids = Student::pluck('nid')->toArray();
        $option = $this->faker->numberBetween(1, 15);

        return [
            'student_nid' => $this->faker->randomElement($studentNids),
            'phone'       => $option & 1 ? $this->faker->phoneNumber : null,
            'email'       => $option & 2 ? $this->faker->email : null,
            'facebook'    => $option & 4 ? $this->faker->url : null,
            'line'        => $option & 8 ? $this->faker->userName : null,
        ];
    }
}
