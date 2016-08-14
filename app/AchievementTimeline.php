<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AchievementTimeline extends Model
{
    public function claim(){
        return $this->belongsTo('App\Claim');
    }  
    public function goal(){
        return $this->belongsTo('App\Goal');
    }
    public function proof(){
        return $this->belongsTo('App\Proof');
    }
}
