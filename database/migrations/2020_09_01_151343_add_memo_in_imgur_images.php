<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemoInImgurImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imgur_images', function (Blueprint $table) {
            $table->string('memo')->nullable()->comment('備註')->after('club_type');
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
            $table->dropColumn('memo');
        });
    }
}
