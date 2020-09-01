<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleEventIdInTeaParties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tea_parties', function (Blueprint $table) {
            $table->string('google_event_id')->nullable()->comment('Google日曆活動ID')->after('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tea_parties', function (Blueprint $table) {
            $table->dropColumn('google_event_id');
        });
    }
}
