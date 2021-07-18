<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDataUpdateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_update_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->comment('申請者');
            $table->unsignedInteger('club_id')->comment('社團');
            $table->string('reason')->comment('申請理由');
            $table->timestamp('submit_at')->nullable()->comment('申請提交時間');
            $table->unsignedInteger('reviewer_id')->nullable()->comment('審核者');
            $table->timestamp('review_at')->nullable()->comment('審核時間');
            $table->boolean('review_result')->nullable()->comment('審核通過');
            $table->string('review_comment')->nullable()->comment('審核評語');
            $table->text('original_description')->nullable()->comment('原簡介');
            $table->string('original_url')->nullable()->comment('原網址');
            $table->text('description')->nullable()->comment('簡介');
            $table->string('url')->nullable()->comment('網址');
            $table->text('original_extra_info')->nullable()->comment('原額外資訊');
            $table->text('extra_info')->nullable()->comment('額外資訊');
            $table->string('original_custom_question')->nullable()->comment('原自訂問題');
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
        Schema::dropIfExists('data_update_requests');
    }
}
