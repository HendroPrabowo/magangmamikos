<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function rooms(){
        return $this->hasMany('App\Room');
    }
}
