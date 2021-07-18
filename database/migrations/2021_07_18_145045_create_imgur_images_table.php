<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImgurImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imgur_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imgur_id');
            $table->string('file_name')->comment('完整原始檔名');
            $table->string('extension')->comment('副檔名');
            $table->string('delete_hash');
            $table->unsignedInteger('club_id')->nullable()->comment('所屬社團');
            $table->string('club_type');
            $table->string('memo')->nullable()->comment('備註');
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
        Schema::dropIfExists('imgur_images');
    }
}
