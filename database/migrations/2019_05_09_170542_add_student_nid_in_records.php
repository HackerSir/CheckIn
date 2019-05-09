<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStudentNidInRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('records', function (Blueprint $table) {
            $table->string('student_nid')->nullable()->comment('對應學生')->after('student_id');

            $table->foreign('student_nid')->references('nid')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        \App\Record::whereNotNull('student_id')->with('student')->orderBy('id')->chunk(100, function ($records) {
            /** @var \Illuminate\Database\Eloquent\Collection|\App\Record[] $records */
            foreach ($records as $record) {
                $student = DB::table('students')->where('id', $record->student_id)->first();
                DB::table('records')->where('student_id', $student->id)
                    ->update(['student_nid' => $student->nid]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->dropForeign(['student_nid']);
            $table->dropColumn('student_nid');
        });
    }
}
