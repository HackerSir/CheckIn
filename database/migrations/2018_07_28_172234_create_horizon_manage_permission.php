<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateHorizonManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permHorizonManage = Permission::create([
            'name'         => 'horizon.manage',
            'display_name' => '查看Horizon頁面',
            'description'  => '進入Horizon頁面，查看Horizon狀態',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permHorizonManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Permission::where('name', 'horizon.manage')->delete();
    }
}
