<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MakeClassNullableInExtraTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extra_tickets', function (Blueprint $table) {
            $table->string('class')->nullable()->comment('系級')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extra_tickets', function (Blueprint $table) {
            $table->string('class')->nullable(false)->comment('系級')->change();
        });
    }
}
