<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentRecordManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = Permission::create([
            'name'         => 'payment-record.manage',
            'display_name' => '繳費紀錄管理',
            'description'  => '檢視、管理各社團繳費紀錄',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permission);
        /* @var Role $eas */
        $eas = Role::where('name', 'EAS')->first();
        $eas->attachPermission($permission);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'payment-record.manage')->delete();
    }
}
