<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookSurvey extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function book_survey(){
        return $this->belongsTo('App\Kost');
    }
}
