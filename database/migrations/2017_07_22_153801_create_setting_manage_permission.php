<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateSettingManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permSettingManage = Permission::create([
            'name'         => 'setting.manage',
            'display_name' => '管理設定',
            'description'  => '調整活動設定',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permSettingManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Permission::where('name', 'setting.manage')->delete();
    }
}
