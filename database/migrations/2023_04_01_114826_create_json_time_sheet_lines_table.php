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
        Schema::create('json_time_sheet_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('time_sheet_id')->index('json_time_sheet_lines_time_sheet_id_foreign');
            $table->text('data');
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
        Schema::dropIfExists('json_time_sheet_lines');
    }
};
