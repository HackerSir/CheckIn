<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStudentNidInStudentTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_tickets', function (Blueprint $table) {
            $table->string('student_nid')->nullable()->comment('對應學生')->after('student_id');

            $table->foreign('student_nid')->references('nid')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        \App\StudentTicket::whereNotNull('student_id')->with('student')->orderBy('id')
            ->chunk(100, function ($studentTickets) {
                /** @var \Illuminate\Database\Eloquent\Collection|\App\StudentTicket[] $studentTickets */
                foreach ($studentTickets as $studentTicket) {
                    DB::table('student_tickets')->where('student_id', $studentTicket->student->id)
                        ->update(['student_nid' => $studentTicket->student->nid]);
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
        Schema::table('student_tickets', function (Blueprint $table) {
            $table->dropForeign(['student_nid']);
            $table->dropColumn('student_nid');
        });
    }
}
