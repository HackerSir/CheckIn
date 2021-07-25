<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

class AssignPermissionsToRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roleIds = Role::pluck('id', 'name');
        $permissionIds = Permission::pluck('id', 'name');

        DB::table('permission_role')->insert([
            [
                'permission_id' => $permissionIds['menu.view'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['user.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['user.view'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['log-viewer.access'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['role.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['student.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['student.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['qrcode.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['qrcode.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['qrcode.manage'],
                'role_id'       => $roleIds['staff'],
            ],
            [
                'permission_id' => $permissionIds['activity-menu.view'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['activity-menu.view'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['activity-menu.view'],
                'role_id'       => $roleIds['staff'],
            ],
            [
                'permission_id' => $permissionIds['booth.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['booth.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['club.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['club.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['setting.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['setting.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['club-type.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['club-type.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['api-key.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['record.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['record.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['ticket.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['ticket.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['extra-ticket.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['extra-ticket.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['feedback.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['feedback.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['qrcode-set.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['qrcode-set.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['stats.access'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['stats.access'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['student-path.view'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['horizon.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['broadcast.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['survey.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['student-ticket.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['student-ticket.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['tea-party.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['tea-party.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['payment-record.manage'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['payment-record.manage'],
                'role_id'       => $roleIds['EAS'],
            ],
            [
                'permission_id' => $permissionIds['activity-log.access'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['ticket.show-ticket'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['extra-ticket.show-ticket'],
                'role_id'       => $roleIds['Admin'],
            ],
            [
                'permission_id' => $permissionIds['student-ticket.show-ticket'],
                'role_id'       => $roleIds['Admin'],
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permission_role')->delete();
    }
}
