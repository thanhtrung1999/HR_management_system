<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpgradeForeignkey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('employees')) {
            if (Schema::hasTable('departments')) {
                Schema::table('employees', function (Blueprint $table) {
                    $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
                });
                Schema::table('departments', function (Blueprint $table) {
                    $table->foreign('employee_id')->references('id')->on('employees')->onDelete('no action');
                });
            }
            if (Schema::hasTable('working_days')) {
                Schema::table('working_days', function (Blueprint $table) {
                    $table->foreign('employee_id')->references('id')->on('employees')->onDelete('no action');
                });
            }
            if (Schema::hasTable('requests')) {
                Schema::table('requests', function (Blueprint $table) {
                    $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
                });
            }
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
