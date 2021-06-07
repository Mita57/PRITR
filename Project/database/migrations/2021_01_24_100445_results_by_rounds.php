<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ResultsByRounds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results_by_rounds', function (Blueprint $table) {
            $table->integer('round_id');
            $table->string('user');
            $table->integer('place');
            $table->integer('time');
            $table->foreign('round_id')->references('id')->on('br_games_rounds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results_by_rounds');
    }
}
