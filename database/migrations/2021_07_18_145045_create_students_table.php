<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('nid')->primary()->comment('學號');
            $table->string('name')->comment('姓名');
            $table->string('type')->nullable()->comment('類型');
            $table->string('unit_id')->nullable()->comment('科系ID');
            $table->string('class')->nullable()->comment('班級');
            $table->string('unit_name')->nullable()->comment('科系');
            $table->string('dept_id')->nullable()->comment('學院ID');
            $table->string('dept_name')->nullable()->comment('學院');
            $table->integer('in_year')->nullable()->comment('入學學年度');
            $table->string('gender')->nullable()->comment('性別');
            $table->boolean('consider_as_freshman')->default(false)->comment('視為新生');
            $table->boolean('is_dummy')->default(false)->comment('是否為虛構資料');
            $table->timestamp('fetch_at')->nullable()->comment('最後一次由API獲取資料時間');
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
        Schema::dropIfExists('students');
    }
}
