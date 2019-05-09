<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStudentNidInTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('tickets', function (Blueprint $table) {
            $table->string('student_nid')->nullable()->comment('對應學生')->after('student_id');

            $table->foreign('student_nid')->references('nid')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        \App\Ticket::whereNotNull('student_id')->with('student')->orderBy('id')->chunk(100, function ($tickets) {
            /** @var \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets */
            foreach ($tickets as $ticket) {
                DB::table('tickets')->where('student_id', $ticket->student->id)
                    ->update(['student_nid' => $ticket->student->nid]);
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
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['student_nid']);
            $table->dropColumn('student_nid');
        });
    }
}
