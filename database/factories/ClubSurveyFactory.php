<?php

namespace Database\Factories;

use App\Models\ClubSurvey;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubSurveyFactory extends Factory
{
    protected $model = ClubSurvey::class;

    public function definition(): array
    {
        $userIds = User::whereHas('club')->pluck('id')->toArray();
        /** @var User $user */
        $user = User::find($this->faker->randomElement($userIds));

        return [
            'user_id' => $user->id,
            'club_id' => $user->club->id,
            'rating'  => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->optional()->paragraph,
        ];
    }
}
