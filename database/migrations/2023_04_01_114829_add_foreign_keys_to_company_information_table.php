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
        Schema::table('company_information', function (Blueprint $table) {
            $table->foreign(['country_id'])->references(['id'])->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['district_id'])->references(['id'])->on('districts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['region_id'])->references(['id'])->on('regions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['ward_id'])->references(['id'])->on('wards')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_information', function (Blueprint $table) {
            $table->dropForeign('company_information_country_id_foreign');
            $table->dropForeign('company_information_district_id_foreign');
            $table->dropForeign('company_information_region_id_foreign');
            $table->dropForeign('company_information_ward_id_foreign');
        });
    }
};
