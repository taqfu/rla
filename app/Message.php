<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    public function receiver (){
        return $this->belongsTo('\App\User', 'to_user_id');
    }
    public function sender(){
        return $this->belongsTo('\App\User', 'from_user_id');
    }
}
