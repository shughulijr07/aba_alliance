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
        Schema::create('time_sheet_late_submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->index('time_sheet_late_submissions_staff_id_foreign');
            $table->unsignedBigInteger('time_sheet_id')->nullable()->index('time_sheet_late_submissions_time_sheet_id_foreign');
            $table->string('year', 20);
            $table->string('month', 2);
            $table->string('reason', 500)->nullable();
            $table->string('status', 20);
            $table->string('unlocked_by', 50)->nullable();
            $table->date('unlocking_time')->nullable();
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
        Schema::dropIfExists('time_sheet_late_submissions');
    }
};
