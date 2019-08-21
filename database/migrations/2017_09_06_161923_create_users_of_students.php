<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersOfStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //找出沒有使用者的學生
        /** @var \App\Student[]|\Illuminate\Database\Eloquent\Collection $students */
        $students = \App\Student::whereNull('user_id')->get();
        foreach ($students as $student) {
            //建立使用者
            $email = $student->nid . '@fcu.edu.tw';
            /** @var \App\User $user */
            $user = \App\User::updateOrCreate([
                'email' => $email,
            ], [
                'name'        => $student->name,
                'password'    => '',
                'confirm_at'  => \Carbon\Carbon::now(),
                'register_at' => \Carbon\Carbon::now(),
                'register_ip' => request()->getClientIp(),
            ]);
            //綁定
            $user->student()->save($student);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
