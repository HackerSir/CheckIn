<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('club_type_id')->nullable()->comment('社團類型');
            $table->string('name')->comment('名稱');
            $table->text('description')->nullable()->comment('簡介');
            $table->string('url')->nullable()->comment('網址');
            $table->string('image_url')->nullable()->comment('圖片網址');
            $table->timestamps();

            $table->foreign('club_type_id')->references('id')->on('club_types')
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
        Schema::dropIfExists('clubs');
    }
}
