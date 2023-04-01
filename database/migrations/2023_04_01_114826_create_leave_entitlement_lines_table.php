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
        Schema::create('leave_entitlement_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leave_entitlement_id')->index('leave_entitlement_lines_leave_entitlement_id_foreign');
            $table->string('type_of_leave', 60);
            $table->string('number_of_days', 3);
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
        Schema::dropIfExists('leave_entitlement_lines');
    }
};
