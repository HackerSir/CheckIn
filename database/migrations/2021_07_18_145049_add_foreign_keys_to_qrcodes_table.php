<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQrcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qrcodes', function (Blueprint $table) {
            $table->foreign('qrcode_set_id')->references('id')->on('qrcode_sets')
                ->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign('student_nid')->references('nid')->on('students')
                ->onUpdate('CASCADE')->onDelete('SET NULL');
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
            $table->dropForeign(['student_nid']);
        });
    }
}
