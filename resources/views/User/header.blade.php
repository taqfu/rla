<?php
$point_caption = $profile->score!=1 ? "points" : "point";
?>
<div class='clearfix'>
        <div class='col-xs-4'>
            @if (Auth::user() && Auth::user()->id != $profile->id)
            <div>
                <a  href="{{route('new_message', ['id'=>$profile->id])}}">Send Message</a>
            </div>
            @endif
            <div>{{$profile->score}} {{$point_caption}}</div>
        </div>
        <div class='col-xs-8 pull-right text-right'>
            Registered {{date('M d, Y', strtotime($profile->created_at))}}
        </div>
</div>
