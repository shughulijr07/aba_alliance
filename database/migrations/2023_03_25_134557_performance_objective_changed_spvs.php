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
           Schema::create('performance_objective_changed_spvs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('performance_objective_id');
            $table->unsignedBigInteger('old_spv_id');
            $table->unsignedBigInteger('new_spv_id');
            $table->string('changed_by');
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
        Schema::dropIfExists('performance_objective_changed_spvs');
    }
};
