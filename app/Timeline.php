<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    public function achievement(){
        return $this->belongsTo('\App\Achievement');
    }
    public function claim(){
        return $this->belongsTo('\App\Claim');
    }
    public function comment(){
        return $this->belongsTo('\App\Comment');
    }   
    public static function filter_timeline($timeline){
        $filtered_timeline = $timeline->filter(function($timeline_item){
            foreach (session('timeline_filters') as $filter_name=>$filter_is_active){
                $event_name="";
                $name_arr = explode("_", $filter_name);
                foreach ($name_arr as $name_element){
                    if (strlen($event_name)>0){
                        $event_name = $event_name . " ";
                    }
                    $event_name = $event_name . $name_element;
                }
                if($filter_is_active){
                    if (substr($timeline_item->event, 0, strlen($event_name))==$event_name){
                        return $timeline_item;
                    }
                }
            }
        });
        return $filtered_timeline;
    }

    public function goal(){
        return $this->belongsTo('App\Goal');
    }
    public function proof(){
        return $this->belongsTo('\App\Proof');
    }
    public function story(){
        return $this->belongsTo('\App\Story');
    }
    public function user(){
        return $this->belongsTo('\App\User');
    }
    public function vote(){
        return $this->belongsTo('\App\Vote');
    }
}
