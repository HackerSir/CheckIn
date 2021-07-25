<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\ClubType;
use Illuminate\Database\Seeder;

class ClubsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 建立多個社團與分類
     *
     * @return void
     */
    public function run()
    {
        ClubType::factory()->count(8)->create();
        Club::factory()->count(50)->create()->each(function (Club $club) {
            /** @var ClubType $clubType */
            $clubType = ClubType::inRandomOrder()->first();

            $clubType->clubs()->save($club);
        });
    }
}
