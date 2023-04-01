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
        Schema::create('staff_emergency_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->index('staff_emergency_contacts_staff_id_foreign');
            $table->string('full_name', 100);
            $table->string('gender', 10);
            $table->string('relationship', 50);
            $table->string('physical_address', 200);
            $table->string('email', 100)->nullable();
            $table->string('city', 50);
            $table->string('cell_phone', 20);
            $table->string('home_phone', 20)->nullable();
            $table->string('business_phone', 20)->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('staff_emergency_contacts');
    }
};
