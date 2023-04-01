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
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->date('starting_date');
            $table->date('ending_date');
            $table->string('time', 300)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('theme', 300)->nullable();
            $table->string('description', 300)->nullable();
            $table->enum('status', ['Open', 'Closed'])->default('Open');
            $table->enum('booking', ['Open', 'Closed'])->default('Closed');
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
        Schema::dropIfExists('events');
    }
};
