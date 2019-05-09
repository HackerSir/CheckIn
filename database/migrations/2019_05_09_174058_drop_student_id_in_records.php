<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropStudentIdInRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
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
            $table->unsignedInteger('student_id')->nullable()->comment('對應學生')->after('student_nid');

            $table->foreign('student_id')->references('id')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        \App\Record::whereNotNull('student_nid')->with('student')->orderBy('id')->chunk(100, function ($records) {
            /** @var \Illuminate\Database\Eloquent\Collection|\App\Record[] $records */
            foreach ($records as $record) {
                DB::table('records')->where('student_nid', $record->student->nid)
                    ->update(['student_id' => $record->student->id]);
            }
        });
    }
}
