<?php

use Illuminate\Database\Migrations\Migration;

class MigrateClubStaffRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $clubUsers = DB::table('users')->whereNotNull('club_id')->get();
        foreach ($clubUsers as $user) {
            if (!$user->nid) {
                continue;
            }
            DB::table('club_student')->updateOrInsert([
                'student_nid' => $user->nid,
            ], [
                'club_id' => $user->club_id,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $clubStudents = DB::table('club_student')->get();
        foreach ($clubStudents as $clubStudent) {
            DB::table('users')->where(['nid' => $clubStudent->student_nid])
                ->update(['club_id' => $clubStudent->club_id]);
        }
    }
}
