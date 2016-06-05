<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    public function comment(){
        return $this->belongsTo('\App\Comment');
    }   
    public function proof(){
        return $this->belongsTo('\App\Proof');
    }
    public function user(){
        return $this->belongsTo('\App\User');
    }
    public function vote(){
        return $this->belongsTo('\App\Vote');
    }
}
