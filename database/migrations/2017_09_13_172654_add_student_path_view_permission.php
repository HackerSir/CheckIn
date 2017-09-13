<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class AddStudentPathViewPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permStudentPathView = Permission::create([
            'name'         => 'student-path.view',
            'display_name' => '檢視學生移動路徑',
            'description'  => '在學生頁面，檢視其移動路徑',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permStudentPathView);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'student-path.view')->delete();
    }
}
