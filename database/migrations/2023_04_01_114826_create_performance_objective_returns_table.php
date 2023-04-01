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
        Schema::create('performance_objective_returns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('performance_objective_id')->index('performance_objective_returns_performance_objective_id_foreign');
            $table->string('level', 20);
            $table->string('done_by', 50);
            $table->string('comments', 300);
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
        Schema::dropIfExists('performance_objective_returns');
    }
};
