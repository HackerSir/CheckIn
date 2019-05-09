<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropStudentIdInStudentTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_tickets', function (Blueprint $table) {
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
        Schema::table('student_tickets', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->nullable()->comment('對應學生')->after('student_nid');

            $table->foreign('student_id')->references('id')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        \App\StudentTicket::whereNotNull('student_nid')->with('student')->orderBy('id')
            ->chunk(100, function ($studentTickets) {
                /** @var \Illuminate\Database\Eloquent\Collection|\App\StudentTicket[] $studentTickets */
                foreach ($studentTickets as $studentTicket) {
                    DB::table('student_tickets')->where('student_nid', $studentTicket->student->nid)
                        ->update(['student_id' => $studentTicket->student->id]);
                }
            });
    }
}
