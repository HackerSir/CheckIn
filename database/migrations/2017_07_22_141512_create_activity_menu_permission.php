<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateActivityMenuPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permActivityMenuView = Permission::create([
            'name'         => 'activity-menu.view',
            'display_name' => '顯示活動選單',
            'description'  => '顯示活動管理選單',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permActivityMenuView);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'activity-menu.view')->delete();
    }
}
