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
        Schema::create('time_sheet_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('time_sheet_id')->index('time_sheet_lines_time_sheet_id_foreign');
            $table->string('type', 100);
            $table->string('type_no', 100);
            $table->string('day', 2);
            $table->string('total_hours', 3)->nullable();
            $table->string('description', 250)->nullable();
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
        Schema::dropIfExists('time_sheet_lines');
    }
};
