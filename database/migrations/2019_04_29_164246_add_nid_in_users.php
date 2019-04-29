<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNidInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nid')->nullable()->comment('NID')->after('name');
        });
        foreach (\App\User::cursor() as $user) {
            /** @var \App\User $user */
            if (ends_with($user->email, '@fcu.edu.tw')) {
                $user->update([
                    'nid' => str_replace('@fcu.edu.tw', '', $user->email),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nid');
        });
    }
}
