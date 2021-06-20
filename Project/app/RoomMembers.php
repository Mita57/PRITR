<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomMembers extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'room_members';

    protected $primaryKey = null;

    public function User() {
        return $this->hasMany('App\User', 'id', 'user_id');
    }

}
