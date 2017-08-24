<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MakeStudentIdAndClubIdNotNullableInFeedback extends Migration
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
            $table->dropForeign(['club_id']);
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->nullable(false)->comment('對應學生')->change();
            $table->unsignedInteger('club_id')->nullable(false)->comment('對應社團')->change();

            $table->foreign('student_id')->references('id')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('club_id')->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('cascade');
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
            $table->dropForeign(['student_id']);
            $table->dropForeign(['club_id']);
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->nullable()->comment('對應學生')->change();
            $table->unsignedInteger('club_id')->nullable()->comment('對應社團')->change();

            $table->foreign('student_id')->references('id')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('club_id')->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
