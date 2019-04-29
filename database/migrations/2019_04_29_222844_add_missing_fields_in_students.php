<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMissingFieldsInStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('type')->nullable()->comment('類型')->after('name');
            $table->string('unit_id')->nullable()->comment('科系ID')->after('type');
            $table->string('dept_id')->nullable()->comment('學院ID')->after('unit_name');
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
            $table->dropColumn('type');
            $table->dropColumn('unit_id');
            $table->dropColumn('dept_id');
        });
    }
}
