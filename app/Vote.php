<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vote extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public function proof(){
        return $this->belongsTo("\App\Proof");
    }
    public function user(){
        return $this->belongsTo("\App\User");
    }
}
