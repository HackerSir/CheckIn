<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropStudentIdInFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
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
        Schema::table('feedback', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->nullable()->comment('對應學生')->after('student_nid');

            $table->foreign('student_id')->references('id')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        \App\Feedback::whereNotNull('student_nid')->with('student')->orderBy('id')->chunk(100, function ($feedback) {
            /** @var \Illuminate\Database\Eloquent\Collection|\App\Feedback[] $feedback */
            foreach ($feedback as $feedbackItem) {
                DB::table('feedback')->where('student_nid', $feedbackItem->student->nid)
                    ->update(['student_id' => $feedbackItem->student->id]);
            }
        });
    }
}
