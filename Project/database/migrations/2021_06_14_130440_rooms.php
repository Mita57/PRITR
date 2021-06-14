<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('id');
            $table->integer('creator_id');
            $table->boolean('curr_game_id');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('curr_game_id')->references('id')->on('classic_games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classic_games');
    }
}
