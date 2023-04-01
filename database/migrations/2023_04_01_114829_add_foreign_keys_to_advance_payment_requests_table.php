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
        Schema::table('advance_payment_requests', function (Blueprint $table) {
            $table->foreign(['project_id'])->references(['id'])->on('projects')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
        Schema::table('advance_payment_requests', function (Blueprint $table) {
            $table->dropForeign('advance_payment_requests_project_id_foreign');
            $table->dropForeign('advance_payment_requests_staff_id_foreign');
        });
    }
};
