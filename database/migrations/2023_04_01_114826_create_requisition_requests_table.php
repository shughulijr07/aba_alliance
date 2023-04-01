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
        Schema::create('requisition_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->index('requisition_requests_staff_id_foreign');
            $table->string('project_code', 50);
            $table->string('year', 4);
            $table->date('requested_date');
            $table->string('purpose_of_use', 1000);
            $table->string('terms', 50);
            $table->string('responsible_spv', 10);
            $table->string('status', 30);
            $table->string('file', 30);
            $table->string('transferred_to_nav', 30);
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
        Schema::dropIfExists('requisition_requests');
    }
};
