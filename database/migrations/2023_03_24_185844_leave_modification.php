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
           Schema::create('leave_modifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leave_id');
            $table->string('done_by');
            $table->string('level');
            $table->string('leave_type_changed');
            $table->string('original_leave_type');
            $table->string('new_leave_type');
            $table->string('starting_date_changed');
            $table->string('original_starting_date');
            $table->string('new_starting_date');
            $table->string('ending_date_changed');
            $table->string('original_ending_date');
            $table->string('new_ending_date');
            $table->string('leave_payment_changed');
            $table->string('original_leave_payment');
            $table->string('new_leave_payment');
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
        Schema::dropIfExists('leave_modifications');
    }
};
