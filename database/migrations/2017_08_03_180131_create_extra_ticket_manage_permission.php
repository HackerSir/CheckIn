<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateExtraTicketManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permExtraTicketManage = Permission::create([
            'name'         => 'extra-ticket.manage',
            'display_name' => '管理隊輔抽獎編號',
            'description'  => '檢視、管理隊輔抽獎編號',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permExtraTicketManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'extra-ticket.manage')->delete();
    }
}
