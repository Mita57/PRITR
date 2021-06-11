<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Text extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function game() {
        return $this->belongsTo('App\Game');
    }
}
