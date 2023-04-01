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
        Schema::create('staff_dependents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->index('staff_dependents_staff_id_foreign');
            $table->string('full_name', 100);
            $table->date('date_of_birth');
            $table->string('gender', 10);
            $table->string('relationship', 50);
            $table->string('to_be_on_medical', 20);
            $table->string('birth_certificate_no', 100)->nullable();
            $table->string('image', 200)->nullable();
            $table->string('certificate', 200)->nullable();
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
        Schema::dropIfExists('staff_dependents');
    }
};
