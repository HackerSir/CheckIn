<?php

use Illuminate\Database\Migrations\Migration;

class AddDefaultActivityTime extends Migration
{
    protected $tablename;
    protected $keyColumn;
    protected $valueColumn;

    public function __construct()
    {
        $this->tablename = Config::get('settings.table');
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
        DB::table($this->tablename)->updateOrInsert([
            $this->keyColumn => 'start_at',
        ], [
            $this->valueColumn => (new \Carbon\Carbon('today 8am'))->format('Y/m/d H:i'),
        ]);
        DB::table($this->tablename)->updateOrInsert([
            $this->keyColumn => 'end_at',
        ], [
            $this->valueColumn => (new \Carbon\Carbon('today 5pm'))->format('Y/m/d H:i'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table($this->tablename)->where($this->keyColumn, 'start_at')->delete();
        DB::table($this->tablename)->where($this->keyColumn, 'end_at')->delete();
    }
}
