<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExtraTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nid')->unique()->comment('學號');
            $table->string('name')->comment('姓名');
            $table->string('class')->nullable()->comment('系級');
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
        Schema::dropIfExists('extra_tickets');
    }
}
