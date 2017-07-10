<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateManagePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permMenuView = Permission::create([
            'name'         => 'menu.view',
            'display_name' => '顯示管理選單',
            'description'  => '顯示所有網站管理用的選單',
            'protection'   => true,
        ]);

        $permUserManage = Permission::create([
            'name'         => 'user.manage',
            'display_name' => '管理會員',
            'description'  => '修改會員資料、調整會員權限、刪除會員等',
            'protection'   => false,
        ]);

        $permUserView = Permission::create([
            'name'         => 'user.view',
            'display_name' => '查看會員資料',
            'description'  => '查看會員清單、資料、權限等',
            'protection'   => false,
        ]);

        $permLogViewerAccess = Permission::create([
            'name'         => 'log-viewer.access',
            'display_name' => '進入 Log Viewer 面板',
            'description'  => '進入 Log Viewer 面板，對網站記錄進行查詢與管理',
            'protection'   => false,
        ]);

        $permRoleManage = Permission::create([
            'name'         => 'role.manage',
            'display_name' => '管理角色',
            'description'  => '新增、修改、刪除角色',
            'protection'   => false,
        ]);

        // Find Admin and give permission to him
        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permMenuView);
        $admin->attachPermission($permUserManage);
        $admin->attachPermission($permUserView);
        $admin->attachPermission($permLogViewerAccess);
        $admin->attachPermission($permRoleManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'menu.view')->delete();
        Permission::where('name', 'user.manage')->delete();
        Permission::where('name', 'user.view')->delete();
        Permission::where('name', 'log-viewer.access')->delete();
        Permission::where('name', 'role.manage')->delete();
    }
}
