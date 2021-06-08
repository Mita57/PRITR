<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('mmr')->nullable();
            $table->string('last_10')->nullable();
            $table->integer('max_ever')->nullable();
            $table->integer('cpm_sum')->nullable();
            $table->integer('finished_games_overall')->nullable();
            $table->integer('battle_royale_finished')->nullable();
            $table->integer('battle_royale_won')->nullable();
            $table->integer('classic_finished')->nullable();
            $table->integer('classic_won')->nullable();
            $table->integer('arena_got_to_room1')->nullable();
            $table->integer('arena_played')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
