<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrinkLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drink_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('drink_id');
            $table->string('amount');
            $table->string('alcohol_percentage')->nullable();
            $table->string('calories')->nullable();
            $table->date('date');
            $table->time('time');
            $table->timestamps();

            $table->foreign('drink_id')->references('id')->on('drinks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drink_logs');
    }
}
