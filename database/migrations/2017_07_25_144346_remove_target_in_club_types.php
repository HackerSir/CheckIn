<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveTargetInClubTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('club_types', function (Blueprint $table) {
            $table->dropColumn('target');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('club_types', function (Blueprint $table) {
            $table->integer('target')->default(0)->comment('過關需求該類型攤位數量');
        });
    }
}
