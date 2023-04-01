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
        Schema::create('number_series', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('numbered_item_id')->index('number_series_numbered_item_id_foreign');
            $table->string('abbreviation', 10);
            $table->string('separator', 5)->nullable();
            $table->string('year', 4);
            $table->string('month', 2);
            $table->string('include_year', 5);
            $table->string('include_month', 5);
            $table->integer('starting_no');
            $table->integer('increment_by');
            $table->integer('last_no_used');
            $table->integer('number_of_digits');
            $table->string('first_no_used_code', 30);
            $table->string('last_no_used_code', 30);
            $table->string('reset_on', 30);
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
        Schema::dropIfExists('number_series');
    }
};
