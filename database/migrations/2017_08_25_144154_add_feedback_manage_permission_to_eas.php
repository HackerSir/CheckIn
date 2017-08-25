<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class AddFeedbackManagePermissionToEas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permFeedbackManage = Permission::where('name', 'feedback.manage')->first();

        /* @var Role $eas */
        $eas = Role::where('name', 'EAS')->first();
        $eas->attachPermission($permFeedbackManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permFeedbackManage = Permission::where('name', 'feedback.manage')->first();

        /* @var Role $eas */
        $eas = Role::where('name', 'EAS')->first();
        $eas->detachPermission($permFeedbackManage);
    }
}
