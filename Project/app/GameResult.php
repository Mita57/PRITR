<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameResult extends Model
{
    use HasFactory;
    protected $table = 'classic_results';

    public function user() {
        return $this->hasMany('App\User');
    }
}
