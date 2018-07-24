<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateClubTypeManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permClubTypeManage = Permission::create([
            'name'         => 'club-type.manage',
            'display_name' => '管理社團類型',
            'description'  => '查看、編輯社團類型與標籤顏色等',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permClubTypeManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Permission::where('name', 'club-type.manage')->delete();
    }
}
