<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropStudentIdInStudentSurveys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_surveys', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
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
            $table->unsignedInteger('student_id')->nullable()->comment('對應學生')->after('student_nid');

            $table->foreign('student_id')->references('id')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        \App\StudentSurvey::whereNotNull('student_nid')->with('student')->orderBy('id')
            ->chunk(100, function ($studentSurveys) {
                /** @var \Illuminate\Database\Eloquent\Collection|\App\StudentSurvey[] $studentSurveys */
                foreach ($studentSurveys as $studentSurvey) {
                    DB::table('student_surveys')->where('student_nid', $studentSurvey->student->nid)
                        ->update(['student_id' => $studentSurvey->student->id]);
                }
            });
    }
}
