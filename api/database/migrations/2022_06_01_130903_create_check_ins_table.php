<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('check_in_time')->nullable();
            $table->string('check_in_location')->nullable();
            $table->string('check_in_lat')->default(0);
            $table->string('check_in_lng')->default(0);
            $table->string('check_out_time')->nullable();
            $table->string('check_out_location')->nullable();
            $table->string('check_out_lat')->nullable();
            $table->string('check_out_lng')->nullable();
            $table->unsignedBigInteger('attendance_id');
            $table->foreign('attendance_id')->references('id')->on('attendances');
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
        Schema::dropIfExists('check_ins');
    }
}
