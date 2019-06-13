<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddOriginalColumnsInFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->string('phone')->nullable()->comment('聯絡電話')->after('club_id');
            $table->string('email')->nullable()->comment('聯絡信箱')->after('phone');
            $table->string('facebook')->nullable()->comment('FB個人檔案連結')->after('email');
            $table->string('line')->nullable()->comment('LINE ID')->after('facebook');
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
            $table->dropColumn('phone');
            $table->dropColumn('email');
            $table->dropColumn('facebook');
            $table->dropColumn('line');
        });
    }
}
