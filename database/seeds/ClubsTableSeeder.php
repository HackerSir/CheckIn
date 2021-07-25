<?php

namespace Database\Seeders;

use App\Club;
use App\ClubType;
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
        factory(App\ClubType::class, 8)->create();

        factory(App\Club::class, 50)->create()->each(function (Club $club) {
            /** @var ClubType $clubType */
            $clubType = ClubType::inRandomOrder()->first();

            $clubType->clubs()->save($club);
        });
    }
}
