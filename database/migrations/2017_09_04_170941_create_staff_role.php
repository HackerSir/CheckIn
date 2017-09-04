<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateStaffRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $staff = Role::create([
            'name'         => 'staff',
            'display_name' => '服務台',
            'description'  => '服務台工作人員',
        ]);

        $permissionsList = [
            'qrcode.manage',
            'activity-menu.view',
        ];

        $staff->attachPermissions(Permission::whereIn('name', $permissionsList)->get());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Role::where('name', 'staff')->delete();
    }
}
