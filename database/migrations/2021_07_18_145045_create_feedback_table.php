<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_nid')->nullable()->comment('對應學生');
            $table->unsignedInteger('club_id')->comment('對應社團');
            $table->string('phone')->nullable()->comment('聯絡電話');
            $table->string('email')->nullable()->comment('聯絡信箱');
            $table->string('facebook')->nullable()->comment('FB個人檔案連結');
            $table->string('line')->nullable()->comment('LINE ID');
            $table->boolean('include_phone')->default(false)->comment('包含聯絡電話');
            $table->boolean('include_email')->default(false)->comment('包含聯絡信箱');
            $table->boolean('include_facebook')->default(false)->comment('包含FB個人檔案連結');
            $table->boolean('include_line')->default(false)->comment('包含LINE ID');
            $table->string('message')->nullable()->comment('附加訊息');
            $table->string('custom_question')->nullable()->comment('社團自訂問題');
            $table->string('answer_of_custom_question')->nullable()->comment('對於社團自訂問題的回答');
            $table->boolean('join_club_intention')->nullable()->comment('加入社團意願');
            $table->boolean('join_tea_party_intention')->nullable()->comment('參加迎新茶會意願');
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
        Schema::dropIfExists('feedback');
    }
}
