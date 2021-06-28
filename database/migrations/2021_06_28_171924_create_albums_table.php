<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('spotify_id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->date('release_date')->nullable();
            $table->string('label')->nullable();
            $table->integer('total_tracks')->nullable();
            $table->integer('popularity')->nullable();
            $table->string('type');
            $table->integer('play_count')->default(0);
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
        Schema::dropIfExists('albums');
    }
}
