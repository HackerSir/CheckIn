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
            $table->unsignedInteger('club_id')->nullable()->comment('對應社團');
            $table->string('name')->comment('名稱');
            $table->float('longitude', 10, 7)->nullable()->comment('經度');
            $table->float('latitude', 10, 7)->nullable()->comment('緯度');
            $table->timestamps();

            $table->foreign('club_id')->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('set null');
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
