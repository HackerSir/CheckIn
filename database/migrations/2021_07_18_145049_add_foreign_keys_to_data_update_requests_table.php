<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDataUpdateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_update_requests', function (Blueprint $table) {
            $table->foreign('club_id')->references('id')->on('clubs')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('reviewer_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_update_requests', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
            $table->dropForeign(['reviewer_id']);
            $table->dropForeign(['user_id']);
        });
    }
}
