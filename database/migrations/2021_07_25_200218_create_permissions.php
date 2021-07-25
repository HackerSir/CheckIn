<?php

use Illuminate\Database\Migrations\Migration;

class CreatePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->insert([
            [
                'name'         => 'menu.view',
                'display_name' => '顯示管理選單',
                'description'  => '顯示所有網站管理用的選單',
            ],
            [
                'name'         => 'user.manage',
                'display_name' => '管理會員',
                'description'  => '修改會員資料、調整會員權限、刪除會員等',
            ],
            [
                'name'         => 'user.view',
                'display_name' => '查看會員資料',
                'description'  => '查看會員清單、資料、權限等',
            ],
            [
                'name'         => 'log-viewer.access',
                'display_name' => '進入 Log Viewer 面板',
                'description'  => '進入 Log Viewer 面板，對網站記錄進行查詢與管理',
            ],
            [
                'name'         => 'role.manage',
                'display_name' => '管理角色',
                'description'  => '新增、修改、刪除角色',
            ],
            [
                'name'         => 'student.manage',
                'display_name' => '管理學生',
                'description'  => '查看學生資料、新增學生資料等',
            ],
            [
                'name'         => 'qrcode.manage',
                'display_name' => '管理QRCode',
                'description'  => '查看QRCode、為學生綁定QRCode等',
            ],
            [
                'name'         => 'activity-menu.view',
                'display_name' => '顯示活動選單',
                'description'  => '顯示活動管理選單',
            ],
            [
                'name'         => 'booth.manage',
                'display_name' => '管理攤位',
                'description'  => '查看攤位、編輯攤位等',
            ],
            [
                'name'         => 'club.manage',
                'display_name' => '管理社團',
                'description'  => '查看社團、編輯社團等',
            ],
            [
                'name'         => 'setting.manage',
                'display_name' => '管理設定',
                'description'  => '調整活動設定',
            ],
            [
                'name'         => 'club-type.manage',
                'display_name' => '管理社團類型',
                'description'  => '查看、編輯社團類型與標籤顏色等',
            ],
            [
                'name'         => 'api-key.manage',
                'display_name' => '管理ApiKey',
                'description'  => '管理GoogleApi所使用的Key',
            ],
            [
                'name'         => 'record.manage',
                'display_name' => '管理打卡紀錄',
                'description'  => '檢視、管理打卡紀錄',
            ],
            [
                'name'         => 'ticket.manage',
                'display_name' => '管理抽獎編號',
                'description'  => '檢視、管理抽獎編號',
            ],
            [
                'name'         => 'extra-ticket.manage',
                'display_name' => '管理工作人員抽獎編號',
                'description'  => '檢視、管理工作人員抽獎編號',
            ],
            [
                'name'         => 'feedback.manage',
                'display_name' => '管理回饋資料',
                'description'  => '檢視、管理全部回饋資料',
            ],
            [
                'name'         => 'qrcode-set.manage',
                'display_name' => '管理QRCode集',
                'description'  => '管理QRCode集',
            ],
            [
                'name'         => 'stats.access',
                'display_name' => '查看統計頁面',
                'description'  => '進入統計頁面，查看各項統計數值',
            ],
            [
                'name'         => 'student-path.view',
                'display_name' => '檢視學生移動路徑',
                'description'  => '在學生頁面，檢視其移動路徑',
            ],
            [
                'name'         => 'horizon.manage',
                'display_name' => '查看Horizon頁面',
                'description'  => '進入Horizon頁面，查看Horizon狀態',
            ],
            [
                'name'         => 'broadcast.manage',
                'display_name' => '查看Broadcast頁面',
                'description'  => '進入Broadcast頁面，查看Broadcast狀態',
            ],
            [
                'name'         => 'survey.manage',
                'display_name' => '管理問卷',
                'description'  => '管理所有問卷',
            ],
            [
                'name'         => 'student-ticket.manage',
                'display_name' => '管理學生抽獎編號',
                'description'  => '檢視、管理學生抽獎編號',
            ],
            [
                'name'         => 'tea-party.manage',
                'display_name' => '茶會管理',
                'description'  => '檢視、管理各社團茶會資訊',
            ],
            [
                'name'         => 'payment-record.manage',
                'display_name' => '繳費紀錄管理',
                'description'  => '檢視、管理各社團繳費紀錄',
            ],
            [
                'name'         => 'activity-log.access',
                'display_name' => '查看活動紀錄',
                'description'  => '查看網站各類型活動紀錄',
            ],
            [
                'name'         => 'ticket.show-ticket',
                'display_name' => '展示抽獎編號',
                'description'  => '展示抽獎編號',
            ],
            [
                'name'         => 'extra-ticket.show-ticket',
                'display_name' => '展示工作人員抽獎編號',
                'description'  => '展示工作人員抽獎編號',
            ],
            [
                'name'         => 'student-ticket.show-ticket',
                'display_name' => '展示學生抽獎編號',
                'description'  => '展示學生抽獎編號',
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
        DB::table('permissions')->delete();
    }
}
