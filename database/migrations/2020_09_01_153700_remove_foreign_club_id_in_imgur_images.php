<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveForeignClubIdInImgurImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imgur_images', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imgur_images', function (Blueprint $table) {
            $table->foreign('club_id')->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }
}
