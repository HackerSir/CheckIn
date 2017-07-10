<?php

use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create([
            'name'         => 'Admin',
            'display_name' => '管理員',
            'description'  => '擁有最高權限的網站管理者',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Role::where('name', 'Admin')->delete();
    }
}
