<?php

use Illuminate\Database\Migrations\Migration;

class AddClubEditDeadlineAtSettings extends Migration
{
    protected $tableName;
    protected $keyColumn;
    protected $valueColumn;

    public function __construct()
    {
        $this->tableName = Config::get('settings.table');
        $this->keyColumn = Config::get('settings.keyColumn');
        $this->valueColumn = Config::get('settings.valueColumn');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table($this->tableName)->updateOrInsert([
            $this->keyColumn => 'club_edit_deadline',
        ], [
            $this->valueColumn => \Carbon\Carbon::now()->endOfMonth()->format('Y/m/d H:i'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table($this->tableName)->where($this->keyColumn, 'club_edit_deadline')->delete();
    }
}
