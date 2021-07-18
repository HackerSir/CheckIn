<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->foreign('club_id')->references('id')->on('clubs')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('scanned_by_user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign('student_nid')->references('nid')->on('students')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
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
            $table->dropForeign(['club_id']);
            $table->dropForeign(['scanned_by_user_id']);
            $table->dropForeign(['student_nid']);
        });
    }
}
