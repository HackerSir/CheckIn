<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateQrcodeManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permQrcodeManage = Permission::create([
            'name'         => 'qrcode.manage',
            'display_name' => '管理QRCode',
            'description'  => '查看QRCode、為學生綁定QRCode等',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permQrcodeManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'qrcode.manage')->delete();
    }
}
