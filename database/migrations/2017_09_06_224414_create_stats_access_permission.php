<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateStatsAccessPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permStatsAccess = Permission::create([
            'name'         => 'stats.access',
            'display_name' => '查看統計頁面',
            'description'  => '進入統計頁面，查看各項統計數值',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permStatsAccess);
        /* @var Role $eas */
        $eas = Role::where('name', 'EAS')->first();
        $eas->attachPermission($permStatsAccess);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Permission::where('name', 'stats.access')->delete();
    }
}
