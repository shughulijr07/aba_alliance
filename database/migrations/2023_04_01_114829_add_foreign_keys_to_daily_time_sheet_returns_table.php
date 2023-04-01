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
        Schema::table('daily_time_sheet_returns', function (Blueprint $table) {
            $table->foreign(['time_sheet_id'])->references(['id'])->on('daily_time_sheets')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_time_sheet_returns', function (Blueprint $table) {
            $table->dropForeign('daily_time_sheet_returns_time_sheet_id_foreign');
        });
    }
};
