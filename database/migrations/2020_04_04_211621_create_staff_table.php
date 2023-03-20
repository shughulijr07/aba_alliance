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
      Schema::create('staff', function(Blueprint $table){
         $table->bigIncrements('id');
         $table->string('staff_no')->nullable();
         $table->string('first_name');
         $table->string('middle_name')->nullable();
         $table->string('last_name');
         $table->string('gender');
         $table->integer('phone_no')->nullable();
         $table->string('official_email');
         $table->string('personal_email')->nullable();
         $table->string('duty_station');
         $table->string('place_of_birth')->nullable();
         $table->string('home_address')->nullable();
         $table->string('date_of_birth')->nullable();
         $table->string('date_of_employment')->nullable();
         $table->string('date_of_termination')->nullable();
         $table->string('staff_status');
         $table->string('image')->nullable();
         $table->string('signature')->nullable();
         $table->string('user_id')->nullable();
         $table->string('department_id');
         $table->string('job_title_id');
         $table->string('supervisor_id')->nullable();

      });
   }

   public function down()
    {
        Schema::dropIfExists('staff');
    }

};