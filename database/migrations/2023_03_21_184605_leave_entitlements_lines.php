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
            $table->unsignedBigInteger('leave_entitlement_id');
            $table->string('type_of_leave');
            $table->string('number_of_days');
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
