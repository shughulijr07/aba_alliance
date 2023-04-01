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
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->index('leaves_employee_id_foreign');
            $table->string('type');
            $table->string('payment');
            $table->string('year');
            $table->date('starting_date');
            $table->date('ending_date');
            $table->string('description', 300)->nullable();
            $table->string('supporting_document', 200)->nullable();
            $table->string('number_of_babies', 2)->nullable();
            $table->string('status');
            $table->string('responsible_spv');
            $table->string('paid_by_accountant');
            $table->string('modified_by_spv', 3);
            $table->string('modified_by_hrm', 3);
            $table->string('modified_by_adm', 3);
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
        Schema::dropIfExists('leaves');
    }
};
