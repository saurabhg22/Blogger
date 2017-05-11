<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Foundation\Auth\User;

class Blog extends Model
{
    public function user(){
    	return $this->belongsTo('App\User');
    }
}
