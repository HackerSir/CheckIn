<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropStudentIdInTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
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
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->nullable()->comment('對應學生')->after('student_nid');

            $table->foreign('student_id')->references('id')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        \App\Ticket::whereNotNull('student_nid')->with('student')->orderBy('id')->chunk(100, function ($tickets) {
            /** @var \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets */
            foreach ($tickets as $ticket) {
                DB::table('tickets')->where('student_nid', $ticket->student->nid)
                    ->update(['student_id' => $ticket->student->id]);
            }
        });
    }
}
