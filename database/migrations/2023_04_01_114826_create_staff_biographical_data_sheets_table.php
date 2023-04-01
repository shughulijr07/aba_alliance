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
        Schema::create('staff_biographical_data_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->index('staff_biographical_data_sheets_staff_id_foreign');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('address');
            $table->string('contractor_name')->nullable();
            $table->string('contractor_no')->nullable();
            $table->string('position_under_contract')->nullable();
            $table->string('proposed_salary_lcy')->nullable();
            $table->string('proposed_salary_frc')->nullable();
            $table->string('date_of_employment')->nullable();
            $table->string('phone_no');
            $table->string('place_of_birth');
            $table->string('date_of_birth');
            $table->string('citizenship');
            $table->string('home_region')->nullable();
            $table->string('home_district')->nullable();
            $table->string('assigned_country')->nullable();
            $table->string('employment_duration')->nullable();
            $table->text('education');
            $table->text('language_proficiency');
            $table->text('employment_history');
            $table->string('net_salary');
            $table->string('gross_salary');
            $table->text('employment_period_salary');
            $table->text('specific_consultant_services');
            $table->string('certification');
            $table->date('certification_date');
            $table->string('employee_signature')->nullable();
            $table->string('contractor_certification');
            $table->date('contractor_certification_date');
            $table->string('contractor_signature')->nullable();
            $table->string('status', 20);
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
        Schema::dropIfExists('staff_biographical_data_sheets');
    }
};
