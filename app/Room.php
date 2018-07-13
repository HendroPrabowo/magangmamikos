<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function kost(){
        return $this->belongsTo('App\Kost');
    }
}
