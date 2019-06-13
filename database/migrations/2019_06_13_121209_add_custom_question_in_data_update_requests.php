<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCustomQuestionInDataUpdateRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_update_requests', function (Blueprint $table) {
            $table->string('original_custom_question')->nullable()->comment('原自訂問題');
            $table->string('custom_question')->nullable()->comment('自訂問題');
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
            $table->dropColumn('original_custom_question');
            $table->dropColumn('custom_question');
        });
    }
}
