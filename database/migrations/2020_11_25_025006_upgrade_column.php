<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpgradeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('employees', 'position')){
            Schema::table('employees', function (Blueprint $table){
                \Illuminate\Support\Facades\DB::statement('ALTER TABLE `employees` MODIFY COLUMN `position` VARCHAR(100)');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
