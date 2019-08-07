<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('club_id')->comment('社團');
            $table->string('nid')->comment('NID');
            $table->string('name')->nullable()->comment('姓名');
            $table->boolean('is_paid')->nullable()->comment('姓名');
            $table->string('handler')->nullable()->comment('經手人');
            $table->string('note')->nullable()->comment('備註');
            $table->unsignedInteger('user_id')->nullable()->comment('使用者');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('club_id')->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_records');
    }
}
