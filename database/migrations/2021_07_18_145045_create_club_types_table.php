<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClubTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名稱');
            $table->string('color')->comment('標籤顏色');
            $table->boolean('is_counted')->default(true)->comment('是否列入抽獎集點');
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
        Schema::dropIfExists('club_types');
    }
}
