<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCustomQuestionInFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->string('custom_question')->nullable()->comment('社團自訂問題');
            $table->string('answer_of_custom_question')->nullable()->comment('對於社團自訂問題的回答');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn('custom_question');
            $table->dropColumn('answer_of_custom_question');
        });
    }
}
