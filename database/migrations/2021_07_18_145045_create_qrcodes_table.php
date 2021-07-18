<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQrcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->comment('代碼');
            $table->string('student_nid')->nullable()->comment('對應學生');
            $table->timestamp('bind_at')->nullable()->comment('綁定時間');
            $table->unsignedInteger('qrcode_set_id')->nullable();
            $table->boolean('auto_generated')->default(true)->comment('自動建立');
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
        Schema::dropIfExists('qrcodes');
    }
}
