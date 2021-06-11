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
        return $this->belongsTo('App\User', 'id', 'user');
    }
}
