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

$factory->state(App\User::class, 'student', function (Faker\Generator $faker) {
    $isTeacher = $faker->boolean();
    $nid = $isTeacher
        ? $faker->regexify('[DEPMV]([0-9]){7}')
        : $faker->regexify('T[0-9]{5}');

    return [
        'nid' => $nid,
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
        'name'        => $faker->word,
        'description' => $faker->sentence,
        'url'         => $faker->url,
    ];
});

$factory->define(App\ClubType::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->word,
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
    $studentNids = \App\Student::query()->pluck('nid')->toArray();
    $clubIds = \App\Club::query()->pluck('id')->toArray();

    return [
        'student_nid' => $faker->randomElement($studentNids),
        'club_id'     => $faker->randomElement($clubIds),
        'ip'          => $faker->ipv4,
    ];
});

$factory->define(App\Ticket::class, function (Faker\Generator $faker) {
    return [

    ];
});

$factory->define(App\Feedback::class, function (Faker\Generator $faker) {
    $studentNids = \App\Student::query()->pluck('nid')->toArray();
    $clubIds = \App\Club::query()->pluck('id')->toArray();
    $option = $faker->numberBetween(1, 7);

    return [
        'student_nid' => $faker->randomElement($studentNids),
        'club_id'     => $faker->randomElement($clubIds),
        'phone'       => $option & 1 ? $faker->phoneNumber : null,
        'email'       => $option & 2 ? $faker->email : null,
        'message'     => $option & 4 ? $faker->paragraph : null,
    ];
});

$factory->define(App\StudentSurvey::class, function (Faker\Generator $faker) {
    $studentNids = \App\Student::query()->pluck('nid')->toArray();

    return [
        'student_nid' => $faker->randomElement($studentNids),
        'rating'      => $faker->numberBetween(1, 5),
        'comment'     => $faker->optional()->paragraph,
    ];
});

$factory->define(App\ClubSurvey::class, function (Faker\Generator $faker) {
    $userIds = \App\User::query()->whereHas('club')->pluck('id')->toArray();
    /** @var \App\User $user */
    $user = \App\User::query()->find($faker->randomElement($userIds));

    return [
        'user_id' => $user->id,
        'club_id' => $user->club->id,
        'rating'  => $faker->numberBetween(1, 5),
        'comment' => $faker->optional()->paragraph,
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

$factory->define(App\ContactInformation::class, function (Faker\Generator $faker) {
    $studentNids = \App\Student::query()->pluck('nid')->toArray();
    $option = $faker->numberBetween(1, 15);

    return [
        'student_nid' => $faker->randomElement($studentNids),
        'phone'       => $option & 1 ? $faker->phoneNumber : null,
        'email'       => $option & 2 ? $faker->email : null,
        'facebook'    => $option & 4 ? $faker->url : null,
        'line'        => $option & 8 ? $faker->userName : null,
    ];
});
