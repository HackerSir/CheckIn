<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToClubStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('club_student', function (Blueprint $table) {
            $table->foreign('club_id')->references('id')->on('clubs')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('student_nid')->references('nid')->on('students')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('club_student', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
            $table->dropForeign(['student_nid']);
        });
    }
}
