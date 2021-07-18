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
            $table->string('number')->nullable()->comment('社團編號');
            $table->string('name')->comment('名稱');
            $table->text('description')->nullable()->comment('簡介');
            $table->string('url')->nullable()->comment('網址');
            $table->text('extra_info')->nullable()->comment('額外資訊');
            $table->string('custom_question')->nullable()->comment('自訂問題');
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
        Schema::dropIfExists('clubs');
    }
}
