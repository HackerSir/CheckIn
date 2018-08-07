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
            //審核
            $table->unsignedInteger('reviewer_id')->nullable()->comment('審核者');
            $table->timestamp('review_at')->nullable()->comment('審核時間');
            $table->boolean('review_result')->nullable()->comment('審核通過');
            $table->string('review_comment')->nullable()->comment('審核評語');
            //原資料
            $table->text('original_description')->nullable()->comment('原簡介');
            $table->string('original_url')->nullable()->comment('原網址');
            //新資料
            $table->text('description')->nullable()->comment('簡介');
            $table->string('url')->nullable()->comment('網址');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('club_id')->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reviewer_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');
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
