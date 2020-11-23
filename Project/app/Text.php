<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $table = 'Text';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text', 'length', 'topic', 'lang'];
}