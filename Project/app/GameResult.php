<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameResult extends Model
{
    use HasFactory;
    protected $table = 'classic_results';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}

//
//Event::whereHas('participants', function ($query) {
//    return $query->where('IDUser', '=', 1);
//})->get();
