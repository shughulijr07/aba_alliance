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
        Schema::create('leave_entitlement_extensions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leave_entitlement_line_id')->index('leave_entitlement_extensions_line_id_foreign');
            $table->string('no_days', 3);
            $table->string('done_by', 50);
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
        Schema::dropIfExists('leave_entitlement_extensions');
    }
};
