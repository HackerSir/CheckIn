<?php

use Illuminate\Database\Migrations\Migration;

class AddDefaultTarget extends Migration
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
            $this->keyColumn => 'target',
        ], [
            $this->valueColumn => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table($this->tableName)->where($this->keyColumn, 'target')->delete();
    }
}
