<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nid')->nullable()->index()->comment('NID');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('confirm_code', 60)->nullable();
            $table->timestamp('confirm_at')->nullable();
            $table->timestamp('register_at')->nullable();
            $table->string('register_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('google2fa_secret')->nullable();
            $table->timestamp('agree_terms_at')->nullable()->comment('同意條款時間');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
