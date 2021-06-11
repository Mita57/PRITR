<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable {
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'users';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'username', 'email', 'email_verifried_at', 'password', 'mmr', 'last_10',
        'max_ever', 'cpm_sum', 'finished_games_overall', 'battle_royale_finished', 'battle_royale_won',
        'classic_finished', 'classic_won', 'arena_got_to_room1', 'arena_played', 'remember_token',
        'created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function game_result() {
        return $this->hasMany('App\GameResult');
    }


}
