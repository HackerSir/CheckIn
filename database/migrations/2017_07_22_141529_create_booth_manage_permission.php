<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateBoothManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permBoothManage = Permission::create([
            'name'         => 'booth.manage',
            'display_name' => '管理攤位',
            'description'  => '查看攤位、編輯攤位等',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permBoothManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'booth.manage')->delete();
    }
}
