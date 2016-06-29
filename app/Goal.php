<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public function achievement(){
        return $this->belongsTo('App\Achievement');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }

}
