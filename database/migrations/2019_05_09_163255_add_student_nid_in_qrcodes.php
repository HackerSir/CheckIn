<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStudentNidInQrcodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qrcodes', function (Blueprint $table) {
            $table->string('student_nid')->nullable()->comment('對應學生')->after('student_id');

            $table->foreign('student_nid')->references('nid')->on('students')
                ->onUpdate('cascade')->onDelete('set null');
        });
        \App\Qrcode::whereNotNull('student_id')->with('student')->orderBy('id')->chunk(100, function ($qrcodes) {
            /** @var \Illuminate\Database\Eloquent\Collection|\App\Qrcode[] $qrcodes */
            foreach ($qrcodes as $qrcode) {
                DB::table('qrcodes')->where('student_id', $qrcode->student->id)
                    ->update(['student_nid' => $qrcode->student->nid]);
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
        Schema::table('qrcodes', function (Blueprint $table) {
            $table->dropForeign(['student_nid']);
            $table->dropColumn('student_nid');
        });
    }
}
