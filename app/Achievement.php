<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public function user(){
        return $this->belongsTo("\App\User", 'created_by');
    }
    public function proofs(){
        return $this->hasMany("\App\Proof");
    }
    //
}
