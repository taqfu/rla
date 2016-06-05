<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    public function achievement(){
        return $this->belongsTo('\App\Achievement');
    }
    public function proof(){
        return $this->belongsTo('\App\Proof');
    }
    public function vote(){
        return $this->belongsTo('\App\Vote');
    }
    public function user(){
        return $this->belongsTo('\App\User');
    }
}
