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
        Schema::table('number_series', function (Blueprint $table) {
            $table->foreign(['numbered_item_id'])->references(['id'])->on('numbered_items')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('number_series', function (Blueprint $table) {
            $table->dropForeign('number_series_numbered_item_id_foreign');
        });
    }
};
