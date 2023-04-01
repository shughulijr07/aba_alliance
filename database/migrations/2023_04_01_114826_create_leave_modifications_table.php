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
            $table->unsignedBigInteger('leave_id')->index('leave_modifications_leave_id_foreign');
            $table->string('done_by', 50);
            $table->string('level', 20);
            $table->string('leave_type_changed', 5);
            $table->string('original_leave_type', 50);
            $table->string('new_leave_type', 50);
            $table->string('starting_date_changed', 5);
            $table->date('original_starting_date');
            $table->date('new_starting_date');
            $table->string('ending_date_changed', 5);
            $table->date('original_ending_date');
            $table->date('new_ending_date');
            $table->string('leave_payment_changed', 5);
            $table->string('original_leave_payment', 50);
            $table->string('new_leave_payment', 50);
            $table->string('reason', 300);
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
