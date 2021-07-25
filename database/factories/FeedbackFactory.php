<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Feedback;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        $studentNids = Student::pluck('nid')->toArray();
        $clubIds = Club::pluck('id')->toArray();
        $option = $this->faker->numberBetween(1, 15);

        return [
            'student_nid' => $this->faker->randomElement($studentNids),
            'club_id'     => $this->faker->randomElement($clubIds),
            'phone'       => (bool) ($option & 1),
            'email'       => (bool) ($option & 2),
            'facebook'    => (bool) ($option & 4),
            'line'        => (bool) ($option & 8),
            'message'     => $this->faker->optional()->paragraph,
        ];
    }
}
