<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateTicketShowTicketPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permTicketShowTicket = Permission::create([
            'name'         => 'ticket.show-ticket',
            'display_name' => '展示抽獎編號',
            'description'  => '展示抽獎編號',
        ]);

        $permExtraTicketShowTicket = Permission::create([
            'name'         => 'extra-ticket.show-ticket',
            'display_name' => '展示工作人員抽獎編號',
            'description'  => '展示工作人員抽獎編號',
        ]);

        $permStudentTicketShowTicket = Permission::create([
            'name'         => 'student-ticket.show-ticket',
            'display_name' => '展示學生抽獎編號',
            'description'  => '展示學生抽獎編號',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permTicketShowTicket);
        $admin->attachPermission($permExtraTicketShowTicket);
        $admin->attachPermission($permStudentTicketShowTicket);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Permission::whereIn('name', [
            'ticket.show-ticket',
            'extra-ticket.show-ticket',
            'student-ticket.show-ticket',
        ])->delete();
    }
}
