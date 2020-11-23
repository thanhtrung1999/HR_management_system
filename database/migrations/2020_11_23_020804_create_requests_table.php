<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->string('kind_of', 50);
            $table->dateTime('start_at');
            $table->dateTime('start_end');
            $table->text('content');
            $table->tinyInteger('status')->default(0)->comment('Trạng thái yêu cầu: 0 - chưa duyệt, 1 - đã duyệt, 2 - hủy yêu cầu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
