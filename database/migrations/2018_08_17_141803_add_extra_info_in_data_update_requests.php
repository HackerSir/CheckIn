<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddExtraInfoInDataUpdateRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_update_requests', function (Blueprint $table) {
            $table->text('original_extra_info')->nullable()->comment('原額外資訊');
            $table->text('extra_info')->nullable()->comment('額外資訊');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_update_requests', function (Blueprint $table) {
            $table->dropColumn('original_extra_info');
            $table->dropColumn('extra_info');
        });
    }
}
