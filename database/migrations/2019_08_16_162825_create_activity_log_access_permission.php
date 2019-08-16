<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogAccessPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = Permission::create([
            'name'         => 'activity-log.access',
            'display_name' => '查看活動紀錄',
            'description'  => '查看網站各類型活動紀錄',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permission);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'activity-log.access')->delete();
    }
}
