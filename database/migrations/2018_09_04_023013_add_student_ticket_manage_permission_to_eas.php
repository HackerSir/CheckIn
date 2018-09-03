<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class AddStudentTicketManagePermissionToEas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permStudentTicketManage = Permission::where('name', 'student-ticket.manage')->first();

        /* @var Role $eas */
        $eas = Role::where('name', 'EAS')->first();
        $eas->attachPermission($permStudentTicketManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permStudentTicketManage = Permission::where('name', 'student-ticket.manage')->first();

        /* @var Role $eas */
        $eas = Role::where('name', 'EAS')->first();
        $eas->detachPermission($permStudentTicketManage);
    }
}
