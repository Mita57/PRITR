<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassicResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classic_results', function (Blueprint $table) {
            $table->integer('game_id');
            $table->string('user');
            $table->integer('place')->nullable();
            $table->integer('race_time')->nullable();
            $table->integer('completion')->nullable();
            $table->integer('cpm')->nullable();
            $table->foreign('game_id')->references('id')->on('classic_games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classic_results');
    }
}
