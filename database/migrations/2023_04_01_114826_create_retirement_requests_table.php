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
        Schema::create('retirement_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->index('staff_id');
            $table->unsignedBigInteger('payment_request_id')->index('payment_request_id');
            $table->string('purpose_of_payment', 1000);
            $table->date('requested_date');
            $table->string('responsible_spv', 30);
            $table->string('status', 30);
            $table->string('transferred_to_nav', 30);
            $table->string('year', 10);
            $table->string('file', 30);
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
        Schema::dropIfExists('retirement_requests');
    }
};
