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
           Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('queue');
            $table->longText('payload');
            $table->string('attempts');
            $table->timestamp('reserved_at')->useCurrent();
            $table->timestamp('available_at')->useCurrent();
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
        Schema::dropIfExists('jobs');
    }
};
