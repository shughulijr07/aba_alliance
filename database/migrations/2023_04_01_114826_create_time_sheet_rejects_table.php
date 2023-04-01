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
        Schema::create('time_sheet_rejects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('time_sheet_id')->index('time_sheet_rejects_time_sheet_id_foreign');
            $table->string('level', 20);
            $table->string('done_by', 50);
            $table->string('reason', 300)->nullable();
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
        Schema::dropIfExists('time_sheet_rejects');
    }
};
