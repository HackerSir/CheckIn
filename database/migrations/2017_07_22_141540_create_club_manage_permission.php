<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateClubManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permClubManage = Permission::create([
            'name'         => 'club.manage',
            'display_name' => '管理社團',
            'description'  => '查看社團、編輯社團等',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permClubManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'club.manage')->delete();
    }
}
