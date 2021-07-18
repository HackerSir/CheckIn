<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClubStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_student', function (Blueprint $table) {
            $table->string('student_nid')->comment('學生');
            $table->unsignedInteger('club_id')->comment('社團');
            $table->boolean('is_leader')->default(false)->comment('是否為社長');
            $table->timestamps();

            $table->unique(['student_nid', 'club_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('club_student');
    }
}
