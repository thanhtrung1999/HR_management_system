<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateWorkingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('working_days');
        if (!Schema::hasTable('working_days')) {
            Schema::create('working_days', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('employee_id')->nullable();
                $table->foreign('employee_id')->references('id')->on('employees')->onDelete('no action');
                $table->date('working_on_day')->nullable();
                $table->time('checkin_time')->nullable();
                $table->time('checkout_time')->nullable();
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
    }
}
