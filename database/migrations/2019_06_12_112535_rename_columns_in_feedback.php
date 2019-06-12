<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RenameColumnsInFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->renameColumn('phone', 'include_phone');
            $table->renameColumn('email', 'include_email');
            $table->renameColumn('facebook', 'include_facebook');
            $table->renameColumn('line', 'include_line');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->renameColumn('include_phone', 'phone');
            $table->renameColumn('include_email', 'email');
            $table->renameColumn('include_facebook', 'facebook');
            $table->renameColumn('include_line', 'line');
        });
    }
}
