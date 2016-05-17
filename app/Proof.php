<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proof extends Model
{
    public function achievement(){
        return $this->belongsTo("\App\Achievement");
    }
    public function user(){
        return $this->belongsTo("\App\User");
    }
    public function vote(){
        return $this->hasOne("\App\Vote");
    }
    //
}
