<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class Vote extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
        
    public function comments(){
        return $this->hasMany('\App\Comment');
    }
    public function proof(){
        return $this->belongsTo("\App\Proof");
    }
    public function user(){
        return $this->belongsTo("\App\User");
    }
}
