<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nick', 'email', 'password', 'mmr', 'last_10', 'max_ever', 'cpm_sum', 'finished_games_overall',
        'battle_royale_finished', 'battle_royale_won', 'classic_finished', 'classic_won', 'arena_got_to_room1', 'arena_played',];


}
