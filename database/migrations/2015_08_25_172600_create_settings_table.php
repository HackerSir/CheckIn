<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
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
        Schema::create($this->tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string($this->keyColumn)->index();
            $table->text($this->valueColumn);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->tablename);
    }
}
