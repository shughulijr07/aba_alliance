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
        Schema::table('daily_time_sheets', function (Blueprint $table) {
            $table->foreign(['staff_id'])->references(['id'])->on('staff')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_time_sheets', function (Blueprint $table) {
            $table->dropForeign('daily_time_sheets_staff_id_foreign');
        });
    }
};
