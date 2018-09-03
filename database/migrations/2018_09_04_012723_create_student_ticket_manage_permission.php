<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTicketManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permStudentTicketManage = Permission::create([
            'name'         => 'student-ticket.manage',
            'display_name' => '管理學生抽獎編號',
            'description'  => '檢視、管理學生抽獎編號',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permStudentTicketManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Permission::where('name', 'student-ticket.manage')->delete();
    }
}
