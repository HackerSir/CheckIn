<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBoothsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booths', function (Blueprint $table) {
            $table->increments('id');
            $table->string('zone')->nullable()->comment('區域');
            $table->unsignedInteger('club_id')->nullable()->comment('對應社團');
            $table->string('name')->comment('名稱');
            $table->double('longitude', 10, 7)->nullable()->comment('經度');
            $table->double('latitude', 10, 7)->nullable()->comment('緯度');
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
        Schema::dropIfExists('booths');
    }
}
