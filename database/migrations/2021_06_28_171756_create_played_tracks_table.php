<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayedTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('played_tracks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('track_id');
            $table->string('played_from')->nullable();
            $table->string('played_at');
            $table->date('played_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('played_tracks');
    }
}
