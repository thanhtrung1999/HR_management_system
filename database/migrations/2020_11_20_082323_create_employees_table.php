<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 30);
            $table->string('last_name', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 100);
            $table->rememberToken();
            $table->string('position', 30)->comment('Vị trí (Chức vụ trong công ty)');
            $table->unsignedInteger('department_id')->nullable();
//            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set default');
            $table->string('avatar')->nullable();
            $table->tinyInteger('gender')->nullable()->default(1);
            $table->date('birthday')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('address', 50)->nullable();
            $table->tinyInteger('user_type')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
