<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateTeaPartyManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permTeaPartyManage = Permission::create([
            'name'         => 'tea-party.manage',
            'display_name' => '茶會管理',
            'description'  => '檢視、管理各社團茶會資訊',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permTeaPartyManage);
        /* @var Role $eas */
        $eas = Role::where('name', 'EAS')->first();
        $eas->attachPermission($permTeaPartyManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'student-ticket.manage')->delete();
    }
}
