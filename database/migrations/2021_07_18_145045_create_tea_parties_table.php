<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeaPartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tea_parties', function (Blueprint $table) {
            $table->unsignedInteger('club_id')->primary()->comment('對應社團');
            $table->string('name')->comment('茶會名稱');
            $table->timestamp('start_at')->nullable()->comment('開始時間');
            $table->timestamp('end_at')->nullable()->comment('結束時間');
            $table->string('location')->comment('地點');
            $table->string('url')->nullable()->comment('網址');
            $table->string('google_event_id')->nullable()->comment('Google日曆活動ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tea_parties');
    }
}
