<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('leave_plan_rejects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leave_plan_id');
            $table->string('level');
            $table->string('done_by');
            $table->string('reason');
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
        Schema::dropIfExists('leave_plan_rejects');
    }
};
