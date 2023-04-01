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
        Schema::create('system_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('phone_no')->index();
            $table->string('email')->index();
            $table->string('company')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('passport')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->unsignedBigInteger('user_id')->index('system_users_user_id_foreign');
            $table->unsignedBigInteger('system_role_id')->index('system_users_system_role_id_foreign');
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
        Schema::dropIfExists('system_users');
    }
};
