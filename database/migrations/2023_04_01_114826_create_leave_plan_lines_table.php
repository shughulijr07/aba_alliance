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
        Schema::create('leave_plan_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leave_plan_id')->index('leave_plan_lines_leave_plan_id_foreign');
            $table->string('type_of_leave');
            $table->string('payment');
            $table->string('starting_date');
            $table->string('ending_date');
            $table->string('description', 300)->nullable();
            $table->string('supporting_document', 200)->nullable();
            $table->string('status', 10);
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
        Schema::dropIfExists('leave_plan_lines');
    }
};
