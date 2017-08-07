<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Student::class, function (Faker\Generator $faker) {
    $isTeacher = $faker->boolean();
    $nid = $isTeacher
        ? $faker->regexify('[DEPMV]([0-9]){7}')
        : $faker->regexify('T[0-9]{5}');

    return [
        'nid'       => $nid,
        'name'      => $faker->name,
        'class'     => '資訊工程學系一年級丁班',
        'unit_name' => '資訊工程學系',
        'dept_name' => '資訊電機學院',
        'in_year'   => $faker->numberBetween(90, 106),
        'gender'    => $faker->randomElement(['M', 'F']),
    ];
});

$factory->define(App\Qrcode::class, function (Faker\Generator $faker) {
    return [
        'code'    => $faker->unique()->regexify('[A-Z0-9]{8}'),
        'bind_at' => $faker->optional()->dateTime,
    ];
});

$factory->define(App\Club::class, function (Faker\Generator $faker) {
    return [
        'number'      => $faker->optional()->regexify('[A-E]([0-9]){2}'),
        'name'        => $faker->company,
        'description' => $faker->sentence,
        'url'         => $faker->url,
    ];
});

$factory->define(App\ClubType::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->company,
        'color'      => $faker->hexcolor,
        'is_counted' => $faker->boolean(),
    ];
});

$factory->define(App\Booth::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->regexify('[A-E]([0-9]){2}'),
        'longitude' => $faker->randomFloat(7, -180, 180),
        'latitude'  => $faker->randomFloat(7, -90, 90),
    ];
});

$factory->define(App\Record::class, function (Faker\Generator $faker) {
    return [
        'ip' => $faker->ipv4,
    ];
});

$factory->define(App\Ticket::class, function (Faker\Generator $faker) {
    return [

    ];
});

$factory->define(App\Feedback::class, function (Faker\Generator $faker) {
    return [
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
    ];
});

$factory->define(App\ApiKey::class, function (Faker\Generator $faker) {
    $count = $faker->numberBetween(0, 25000);
    $totalCount = $count + $faker->numberBetween(0, 25000);

    return [
        'api_key'     => str_random(),
        'count'       => $count,
        'total_count' => $totalCount,
    ];
});

$factory->define(App\ExtraTicket::class, function (Faker\Generator $faker) {
    $isTeacher = $faker->boolean();
    $nid = $isTeacher
        ? $faker->regexify('[DEPMV]([0-9]){7}')
        : $faker->regexify('T[0-9]{5}');
    $grade = $faker->randomElement(['一', '二', '三', '四', '五', '六']);
    $class = $faker->randomElement(['甲', '乙', '丙', '丁', '戊', '己']);

    return [
        'nid'   => $nid,
        'name'  => $faker->name,
        'class' => "資訊工程學系{$grade}年級{$class}班",
    ];
});
