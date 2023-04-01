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
        Schema::create('daily_time_sheet_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('time_sheet_id')->index('daily_time_sheet_lines_time_sheet_id_foreign');
            $table->string('task_no', 5);
            $table->string('starting_time', 10);
            $table->string('ending_time', 10);
            $table->string('description', 250);
            $table->string('total_hours', 3);
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
        Schema::dropIfExists('daily_time_sheet_lines');
    }
};
