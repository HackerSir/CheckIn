<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip')->comment('打卡IP');
            $table->string('student_nid')->nullable()->comment('對應學生');
            $table->unsignedInteger('club_id')->nullable()->comment('對應社團');
            $table->unsignedInteger('scanned_by_user_id')->nullable()->comment('掃描者');
            $table->boolean('web_scan')->default(false)->comment('使用網站內建掃描器掃描');
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
        Schema::dropIfExists('records');
    }
}
