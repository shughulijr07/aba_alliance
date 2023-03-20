<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvancePaymentRequestsTable extends Migration
{

    public function up()
    {

        Schema::create('advance_payment_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no',50);
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('project_id');
            $table->string('project_code',50);
            $table->string('year',4);
            $table->date('request_date');
            $table->string('responsible_spv',10);
            $table->string('purpose',1000);
            $table->text('details');
            $table->double('total');
            $table->string('attachments',1000)->nullable();
            $table->string('terms',50);
            $table->string('status',30);
            $table->string('comments',500)->nullable();
            $table->enum('transferred_to_nav',['no', 'yes'])->default('no');
            $table->unsignedBigInteger('nav_id')->nullable();
            $table->timestamps();
        });

        Schema::table('advance_payment_requests', function ($table) {
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->foreign('project_id')->references('id')->on('projects');
        });
    }



    public function down()
    {
        Schema::dropIfExists('travel_requests');
    }


}
