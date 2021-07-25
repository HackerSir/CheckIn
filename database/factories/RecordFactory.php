<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Record;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecordFactory extends Factory
{
    protected $model = Record::class;

    public function definition(): array
    {
        $studentNids = Student::pluck('nid')->toArray();
        $clubIds = Club::pluck('id')->toArray();

        return [
            'student_nid' => $this->faker->randomElement($studentNids),
            'club_id'     => $this->faker->randomElement($clubIds),
            'ip'          => $this->faker->ipv4,
        ];
    }
}
