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
        Schema::table('travel_request_returns', function (Blueprint $table) {
            $table->foreign(['travel_request_id'])->references(['id'])->on('travel_requests')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('travel_request_returns', function (Blueprint $table) {
            $table->dropForeign('travel_request_returns_travel_request_id_foreign');
        });
    }
};
