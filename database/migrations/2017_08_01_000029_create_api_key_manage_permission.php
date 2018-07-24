<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateApiKeyManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permApiKeyManage = Permission::create([
            'name'         => 'api-key.manage',
            'display_name' => '管理ApiKey',
            'description'  => '管理GoogleApi所使用的Key',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permApiKeyManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Permission::where('name', 'api-key.manage')->delete();
    }
}
