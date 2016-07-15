<?php
$point_caption = $profile->score!=1 ? "points" : "point";
?>
<h1 class='text-center margin-bottom'>{{$profile->username}}</h1>
<div class='clearfix'>
        <div class='col-xs-4'>
            <h4>
                <strong>
                    Proof Score: {{$profile->score}} Claim Score: {{$profile->claim_score}}</h4>
                </strong>
            @if (Auth::user() && Auth::user()->id != $profile->id)
            <div>
                <a  href="{{route('new_message', ['username'=>$profile->username])}}">Send Message</a>
            </div>
            @endif
        </div>
        <div class='col-xs-8 pull-right text-right'>
            Registered {{date('M d, Y', strtotime($profile->created_at))}}
        </div>
</div>
