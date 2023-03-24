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
        Schema::create('company_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logo');
            $table->string('company_name');
            $table->string('physical_address');
            $table->string('postal_address');
            $table->string('house_no');
            $table->string('plot_no');
            $table->string('street_name');
            $table->string('office_phone_no1');
            $table->string('office_phone_no2');
            $table->string('fax_no');
            $table->string('email');
            $table->string('website');
            $table->string('date_established');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('ward_id');
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
        Schema::dropIfExists('company_information');
    }
};
