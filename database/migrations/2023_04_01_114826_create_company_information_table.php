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
            $table->string('logo')->nullable();
            $table->string('company_name', 100)->nullable();
            $table->string('physical_address', 100)->nullable();
            $table->string('postal_address', 100)->nullable();
            $table->string('house_no', 100)->nullable();
            $table->string('plot_no', 100)->nullable();
            $table->string('street_name', 100)->nullable();
            $table->string('office_phone_no1', 20)->nullable();
            $table->string('office_phone_no2', 20)->nullable();
            $table->string('fax_no', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('website', 100)->nullable();
            $table->date('date_established')->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->index('company_information_country_id_foreign');
            $table->unsignedBigInteger('region_id')->nullable()->index('company_information_region_id_foreign');
            $table->unsignedBigInteger('district_id')->nullable()->index('company_information_district_id_foreign');
            $table->unsignedBigInteger('ward_id')->nullable()->index('company_information_ward_id_foreign');
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
