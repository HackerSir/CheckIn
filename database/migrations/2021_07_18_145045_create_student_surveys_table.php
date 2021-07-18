<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_surveys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_nid')->nullable()->comment('對應學生');
            $table->unsignedInteger('rating')->comment('星等評價');
            $table->text('comment')->nullable()->comment('意見與建議');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_surveys');
    }
}
