<?php

use Illuminate\Database\Migrations\Migration;

class AddDefaultActivityTime extends Migration
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
     * @throws Exception
     */
    public function up()
    {
        DB::table($this->tableName)->updateOrInsert([
            $this->keyColumn => 'start_at',
        ], [
            $this->valueColumn => (new \Carbon\Carbon('today 8am'))->format('Y/m/d H:i'),
        ]);
        DB::table($this->tableName)->updateOrInsert([
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
        DB::table($this->tableName)->where($this->keyColumn, 'start_at')->delete();
        DB::table($this->tableName)->where($this->keyColumn, 'end_at')->delete();
    }
}
