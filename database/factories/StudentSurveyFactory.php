<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\StudentSurvey;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentSurveyFactory extends Factory
{
    protected $model = StudentSurvey::class;

    public function definition(): array
    {
        $studentNids = Student::pluck('nid')->toArray();

        return [
            'student_nid' => $this->faker->randomElement($studentNids),
            'rating'      => $this->faker->numberBetween(1, 5),
            'comment'     => $this->faker->optional()->paragraph,
        ];
    }
}
