<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateBroadcastManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permBroadcastManage = Permission::create([
            'name'         => 'broadcast.manage',
            'display_name' => '查看Broadcast頁面',
            'description'  => '進入Broadcast頁面，查看Broadcast狀態',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permBroadcastManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'broadcast.manage')->delete();
    }
}
