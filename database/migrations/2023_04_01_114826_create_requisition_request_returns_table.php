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
        Schema::create('requisition_request_returns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('requisition_request_id')->index('requisition_request_id');
            $table->string('level', 20);
            $table->string('done_by', 50);
            $table->string('comments', 300);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisition_request_returns');
    }
};
