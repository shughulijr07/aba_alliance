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
        Schema::create('travel_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no', 50);
            $table->unsignedBigInteger('staff_id')->index('travel_requests_staff_id_foreign');
            $table->unsignedBigInteger('project_id')->index('travel_requests_project_id_foreign');
            $table->string('project_code', 50);
            $table->string('year', 4);
            $table->date('departure_date');
            $table->date('returning_date');
            $table->string('responsible_spv', 10);
            $table->string('purpose', 1000);
            $table->text('details');
            $table->string('attachments', 1000)->nullable();
            $table->string('terms', 50);
            $table->string('status', 30);
            $table->enum('transferred_to_nav', ['no', 'yes'])->default('no');
            $table->unsignedBigInteger('nav_id')->nullable();
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
        Schema::dropIfExists('travel_requests');
    }
};
