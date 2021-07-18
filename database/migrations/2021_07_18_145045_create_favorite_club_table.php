<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFavoriteClubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_club', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('使用者');
            $table->unsignedInteger('club_id')->comment('社團');
            $table->timestamps();

            $table->unique(['user_id', 'club_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorite_club');
    }
}
