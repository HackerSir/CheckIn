<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class SetStudentNidAsPrimaryInStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedInteger('id')->change();
            $table->dropPrimary();
            $table->primary('nid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropPrimary();
            $table->primary('id');
        });
        Schema::table('students', function (Blueprint $table) {
            $table->increments('id')->change();
        });
    }
}
