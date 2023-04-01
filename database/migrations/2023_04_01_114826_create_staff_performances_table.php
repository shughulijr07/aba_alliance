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
        Schema::create('staff_performances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->index('staff_performances_staff_id_foreign');
            $table->string('year', 4);
            $table->string('status', 100);
            $table->string('first_quoter_assessing_spv', 50)->nullable();
            $table->string('first_quoter_spv_marks', 3)->nullable();
            $table->string('first_quoter_spv_comments', 500)->nullable();
            $table->string('first_quoter_approved_by', 50)->nullable();
            $table->string('second_quoter_assessing_spv', 50)->nullable();
            $table->string('second_quoter_spv_marks', 3)->nullable();
            $table->string('second_quoter_spv_comments', 500)->nullable();
            $table->string('second_quoter_approved_by', 50)->nullable();
            $table->string('third_quoter_assessing_spv', 50)->nullable();
            $table->string('third_quoter_spv_marks', 3)->nullable();
            $table->string('third_quoter_spv_comments', 500)->nullable();
            $table->string('third_quoter_approved_by', 50)->nullable();
            $table->string('fourth_quoter_assessing_spv', 50)->nullable();
            $table->string('fourth_quoter_spv_marks', 3)->nullable();
            $table->string('fourth_quoter_spv_comments', 500)->nullable();
            $table->string('fourth_quoter_approved_by', 50)->nullable();
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
        Schema::dropIfExists('staff_performances');
    }
};
