<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateQrcodeSetManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permQrcodeManage = Permission::create([
            'name'         => 'qrcode-set.manage',
            'display_name' => '管理QRCode集',
            'description'  => '管理QRCode集',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permQrcodeManage);
        $eas = Role::where('name', 'EAS')->first();
        $eas->attachPermission($permQrcodeManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'qrcode-set.manage')->delete();
    }
}
