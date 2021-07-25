<?php

namespace Database\Factories;

use App\Models\ExtraTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExtraTicketFactory extends Factory
{
    protected $model = ExtraTicket::class;

    public function definition(): array
    {
        $isTeacher = $this->faker->boolean();
        $nid = $isTeacher
            ? $this->faker->regexify('[DEPMV]([0-9]){7}')
            : $this->faker->regexify('T[0-9]{5}');
        $grade = $this->faker->randomElement(['一', '二', '三', '四', '五', '六']);
        $class = $this->faker->randomElement(['甲', '乙', '丙', '丁', '戊', '己']);

        return [
            'nid'   => $nid,
            'name'  => $this->faker->name,
            'class' => "資訊工程學系{$grade}年級{$class}班",
        ];
    }
}
