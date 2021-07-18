<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_information', function (Blueprint $table) {
            $table->string('student_nid')->primary()->comment('對應學生');
            $table->string('phone')->nullable()->comment('聯絡電話');
            $table->string('email')->nullable()->comment('聯絡信箱');
            $table->string('facebook')->nullable()->comment('FB個人檔案連結');
            $table->string('line')->nullable()->comment('LINE ID');
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
        Schema::dropIfExists('contact_information');
    }
}
