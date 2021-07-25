<?php

use Illuminate\Database\Migrations\Migration;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('roles')->insert([
            [
                'name'         => 'Admin',
                'display_name' => '管理員',
                'description'  => '擁有最高權限的網站管理者',
            ],
            [
                'name'         => 'EAS',
                'display_name' => '課外活動組',
                'description'  => '擁有活動權限的管理者',
            ],
            [
                'name'         => 'staff',
                'display_name' => '服務台',
                'description'  => '服務台工作人員',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('roles')->delete();
    }
}
