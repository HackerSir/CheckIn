<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropStudentIdInQrcodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qrcodes', function (Blueprint $table) {
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
        Schema::table('qrcodes', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->nullable()->comment('對應學生')->after('student_nid');

            $table->foreign('student_id')->references('id')->on('students')
                ->onUpdate('cascade')->onDelete('set null');
        });
        \App\Qrcode::whereNotNull('student_nid')->with('student')->orderBy('id')->chunk(100, function ($qrcodes) {
            /** @var \Illuminate\Database\Eloquent\Collection|\App\Qrcode[] $qrcodes */
            foreach ($qrcodes as $qrcode) {
                DB::table('qrcodes')->where('student_nid', $qrcode->student->nid)
                    ->update(['student_id' => $qrcode->student->id]);
            }
        });
    }
}
