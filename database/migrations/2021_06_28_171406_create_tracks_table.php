<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('spotify_id');
            $table->unsignedBigInteger('album_id')->nullable();
            $table->string('name');
            $table->bigInteger('duration_ms');
            $table->tinyInteger('disc_number')->nullable();
            $table->integer('popularity')->nullable();
            $table->integer('track_number')->nullable();
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
        Schema::dropIfExists('tracks');
    }
}
