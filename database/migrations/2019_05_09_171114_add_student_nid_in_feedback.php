<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStudentNidInFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->string('student_nid')->nullable()->comment('對應學生')->after('student_id');

            $table->foreign('student_nid')->references('nid')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        \App\Feedback::whereNotNull('student_id')->with('student')->orderBy('id')->chunk(100, function ($feedback) {
            /** @var \Illuminate\Database\Eloquent\Collection|\App\Feedback[] $feedback */
            foreach ($feedback as $feedbackItem) {
                DB::table('feedback')->where('student_id', $feedbackItem->student->id)
                    ->update(['student_nid' => $feedbackItem->student->nid]);
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
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign(['student_nid']);
            $table->dropColumn('student_nid');
        });
    }
}
