<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStudentNidInStudentSurveys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_surveys', function (Blueprint $table) {
            $table->string('student_nid')->nullable()->comment('對應學生')->after('student_id');

            $table->foreign('student_nid')->references('nid')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        \App\StudentSurvey::whereNotNull('student_id')->with('student')->orderBy('id')
            ->chunk(100, function ($studentSurveys) {
                /** @var \Illuminate\Database\Eloquent\Collection|\App\StudentSurvey[] $studentSurveys */
                foreach ($studentSurveys as $studentSurvey) {
                    DB::table('student_surveys')->where('student_id', $studentSurvey->student->id)
                        ->update(['student_nid' => $studentSurvey->student->nid]);
                }
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_surveys', function (Blueprint $table) {
            $table->dropForeign(['student_nid']);
            $table->dropColumn('student_nid');
        });
    }
}
