<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MakeNonRequiredFieldsNullableInStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('class')->comment('班級')->nullable()->change();
            $table->string('unit_name')->comment('科系')->nullable()->change();
            $table->string('dept_name')->comment('學院')->nullable()->change();
            $table->integer('in_year')->comment('入學學年度')->nullable()->change();
            $table->string('gender')->comment('性別')->nullable()->change();
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
            $table->string('class')->comment('班級')->nullable(false)->change();
            $table->string('unit_name')->comment('科系')->nullable(false)->change();
            $table->string('dept_name')->comment('學院')->nullable(false)->change();
            $table->integer('in_year')->comment('入學學年度')->nullable(false)->change();
            $table->string('gender')->comment('性別')->nullable(false)->change();
        });
    }
}
