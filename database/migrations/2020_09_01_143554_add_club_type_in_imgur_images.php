<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClubTypeInImgurImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imgur_images', function (Blueprint $table) {
            $table->string('club_type')->nullable()->after('club_id');
        });
        DB::table('imgur_images')->update([
            'club_type' => \App\Club::class,
        ]);
        Schema::table('imgur_images', function (Blueprint $table) {
            $table->string('club_type')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imgur_images', function (Blueprint $table) {
            $table->dropColumn('club_type');
        });
    }
}
