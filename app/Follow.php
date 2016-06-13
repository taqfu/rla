<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public function achievement(){
        return $this->belongsTo('\App\Achievement');
    }
    //
}
