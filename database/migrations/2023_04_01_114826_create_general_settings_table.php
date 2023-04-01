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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('supervisors_mode', 50)->nullable();
            $table->string('carry_over_mode', 50)->nullable();
            $table->string('leave_timesheet_link', 50)->nullable();
            $table->string('include_holidays_in_leave', 50)->nullable();
            $table->string('include_weekends_in_leave', 50)->nullable();
            $table->string('time_sheet_data_format', 50)->nullable();
            $table->string('time_sheet_submission_deadline', 2)->nullable();
            $table->string('objectives_submission_deadline', 2)->nullable();
            $table->string('objectives_marking_opening', 5);
            $table->string('objectives_marking_closing', 5);
            $table->string('user_activities_recording_mode', 2)->nullable();
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
        Schema::dropIfExists('general_settings');
    }
};
