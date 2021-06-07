<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BrGamesRounds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('br_games_rounds', function (Blueprint $table) {
            $table->id("id");
            $table->integer('game_id');
            $table->integer('text_id');
            $table->integer('round_num');
            $table->foreign('game_id')->references('id')->on('battle_royale_games');
            $table->foreign('text_id')->references('id')->on('texts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('br_games_rounds');
    }
}
