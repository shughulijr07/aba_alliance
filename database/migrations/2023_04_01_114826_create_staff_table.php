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
        Schema::create('staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('staff_no')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('gender');
            $table->string('phone_no')->nullable();
            $table->string('official_email')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('duty_station')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('home_address')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('date_of_employment')->nullable();
            $table->string('date_of_termination')->nullable();
            $table->string('staff_status');
            $table->string('image')->nullable();
            $table->string('signature', 200)->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('staff_user_id_foreign');
            $table->unsignedBigInteger('department_id')->index('staff_department_id_foreign');
            $table->unsignedBigInteger('job_title_id')->index('staff_job_title_id_foreign');
            $table->string('supervisor_id', 20)->nullable();
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
        Schema::dropIfExists('staff');
    }
};
