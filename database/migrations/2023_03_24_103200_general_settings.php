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
            $table->string('supervisors_mode');
            $table->string('carry_over_mode');
            $table->string('leave_timesheet_link');
            $table->string('include_holidays_in_leave');
            $table->string('time_sheet_data_format');
            $table->string('time_sheet_submission_deadline');
            $table->string('objectives_submission_deadline');
            $table->string('objectives_marking_opening');
            $table->string('objectives_marking_closing');
            $table->string('user_activities_recording_mode');
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
