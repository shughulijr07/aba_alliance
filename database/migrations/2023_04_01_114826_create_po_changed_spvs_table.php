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
        Schema::create('po_changed_spvs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('performance_objective_id')->index('po_changed_spvs_performance_objective_id_foreign');
            $table->string('old_spv_id');
            $table->string('new_spv_id');
            $table->string('changed_by', 50);
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
        Schema::dropIfExists('po_changed_spvs');
    }
};
