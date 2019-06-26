<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIntentionColumnsInFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->tinyInteger('join_club_intention')->nullable()->comment('加入社團意願');
            $table->tinyInteger('join_tea_party_intention')->nullable()->comment('參加迎新茶會意願');
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
            $table->dropColumn('join_club_intention');
            $table->dropColumn('join_tea_party_intention');
        });
    }
}
