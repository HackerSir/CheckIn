<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->comment('對應使用者');
            $table->string('nid')->comment('學號');
            $table->string('name')->comment('姓名');
            $table->string('class')->comment('班級');
            $table->string('unit_name')->comment('科系');
            $table->string('dept_name')->comment('學院');
            $table->integer('in_year')->comment('入學學年度');
            $table->string('gender')->comment('性別');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
