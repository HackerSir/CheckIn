<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateRecordManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permRecordManage = Permission::create([
            'name'         => 'record.manage',
            'display_name' => '管理打卡紀錄',
            'description'  => '檢視、管理打卡紀錄',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permRecordManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'record.manage')->delete();
    }
}
