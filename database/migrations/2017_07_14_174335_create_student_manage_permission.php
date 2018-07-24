<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateStudentManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permStudentManage = Permission::create([
            'name'         => 'student.manage',
            'display_name' => '管理學生',
            'description'  => '查看學生資料、新增學生資料等',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permStudentManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Permission::where('name', 'student.manage')->delete();
    }
}
