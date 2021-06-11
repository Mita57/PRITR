<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $table = 'classic_games';
    public $timestamps = false;

    public function text() {
        return $this->hasOne('App\Text', 'id', 'text_id');
    }
}
