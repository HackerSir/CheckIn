<?php

use Illuminate\Database\Migrations\Migration;

class AddExpiredAtSettings extends Migration
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
            $this->keyColumn => 'feedback_create_expired_at',
        ], [
            $this->valueColumn => \Carbon\Carbon::now()->endOfMonth()->format('Y/m/d H:i'),
        ]);
        DB::table($this->tableName)->updateOrInsert([
            $this->keyColumn => 'feedback_download_expired_at',
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
        DB::table($this->tableName)->where($this->keyColumn, 'feedback_create_expired_at')->delete();
        DB::table($this->tableName)->where($this->keyColumn, 'feedback_download_expired_at')->delete();
    }
}
