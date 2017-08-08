<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permFeedbackManage = Permission::create([
            'name'         => 'feedback.manage',
            'display_name' => '管理回饋資料',
            'description'  => '檢視、管理全部回饋資料',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permFeedbackManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'feedback.manage')->delete();
    }
}
