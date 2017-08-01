<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateTicketManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permTicketManage = Permission::create([
            'name'         => 'ticket.manage',
            'display_name' => '管理抽獎編號',
            'description'  => '檢視、管理抽獎編號',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permTicketManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'ticket.manage')->delete();
    }
}
