<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permSurveyManage = Permission::create([
            'name'         => 'survey.manage',
            'display_name' => '管理問卷',
            'description'  => '管理所有問卷',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permSurveyManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Permission::where('name', 'survey.manage')->delete();
    }
}
