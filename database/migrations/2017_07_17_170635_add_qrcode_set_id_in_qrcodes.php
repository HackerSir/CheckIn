<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddQrcodeSetIdInQrcodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qrcodes', function (Blueprint $table) {
            $table->unsignedInteger('qrcode_set_id')->nullable();

            $table->foreign('qrcode_set_id')->references('id')->on('qrcode_sets')
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
        Schema::table('qrcodes', function (Blueprint $table) {
            $table->dropForeign(['qrcode_set_id']);
            $table->dropColumn('qrcode_set_id');
        });
    }
}
