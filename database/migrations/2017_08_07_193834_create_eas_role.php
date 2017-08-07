<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateEasRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $eas = Role::create([
            'name'         => 'EAS',
            'display_name' => '課外活動組',
            'description'  => '擁有活動權限的管理者',
        ]);

        $permissionsList = [
            'student.manage',
            'qrcode.manage',
            'activity-menu.view',
            'booth.manage',
            'club.manage',
            'setting.manage',
            'club-type.manage',
            'record.manage',
            'ticket.manage',
            'extra-ticket.manage',
        ];

        $eas->attachPermissions(Permission::whereIn('name', $permissionsList)->get());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Role::where('name', 'EAS')->delete();
    }
}
