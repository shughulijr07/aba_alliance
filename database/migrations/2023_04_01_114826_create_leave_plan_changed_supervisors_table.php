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
        Schema::create('leave_plan_changed_supervisors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leave_plan_id')->index('leave_plan_changed_supervisors_leave_plan_id_foreign');
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
        Schema::dropIfExists('leave_plan_changed_supervisors');
    }
};
