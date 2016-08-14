<?php
function format_interval($interval){
        if ($interval->y>0){
            $caption = $interval->y>1 ? " years" : " year";
            return $interval->y . $caption;
        }
        if ($interval->m>0){
            $caption = $interval->m>1 ? " months" : " month";
            return $interval->m . $caption;
        }
        if ($interval->d>0){
            $caption = $interval->d>1 ? " days" : " day";
            return $interval->d . $caption;
        }
        if ($interval->h>0){
            $caption = $interval->h>1 ? " hours" : " hour";
            return $interval->h .  $caption;

        }
        if ($interval->i>0){
            $caption = $interval->i>1 ? " minutes" : " minute";
            return $interval->i .  $caption;

        }
        $caption = $interval->s>1 ? " seconds" : " second";
        return $interval->s .  $caption;
}
function interval($begin, $end){
        $begin = new DateTime($begin);
        if ($end == "now"){
            $end = new DateTime(date('y-m-d H:i:s'));
        } else {
            $end = new DateTime($end);
        }
        $interval = $end->diff($begin);
        return format_interval($interval);

}
?>
