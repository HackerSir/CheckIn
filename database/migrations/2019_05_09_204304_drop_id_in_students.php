<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropIdInStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('id');
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
            $table->unsignedInteger('id')->first();
        });
        $counter = 1;
        \App\Student::orderBy('created_at')->chunk(100, function ($students) use (&$counter) {
            foreach ($students as $student) {
                DB::table('students')->where('nid', $student->nid)->update(['id' => $counter]);
                $counter++;
            }
        });
    }
}
