<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBooleanColunmsInFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->boolean('phone')->default(false)->comment('聯絡電話')->after('club_id');
            $table->boolean('email')->default(false)->comment('聯絡信箱')->after('phone');
            $table->boolean('facebook')->default(false)->comment('FB個人檔案連結')->after('email');
            $table->boolean('line')->default(false)->comment('LINE ID')->after('facebook');
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
