<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('log_id');
            $table->string('brand');
            $table->integer('amount');
            $table->integer('calories');
            $table->integer('food_id')->nullable();
            $table->integer('meal_type_id')->nullable();
            $table->string('name');
            $table->float('carbs')->nullable();
            $table->float('fat')->nullable();
            $table->float('fiber')->nullable();
            $table->float('protein')->nullable();
            $table->float('sodium')->nullable();
            $table->date('log_date');
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
        Schema::dropIfExists('food_logs');
    }
}
