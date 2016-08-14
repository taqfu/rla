<?php
$point_caption = $profile->score!=1 ? "points" : "point";
?>
<h1 class='text-center margin-bottom'>{{$profile->username}}</h1>
<div class='clearfix'>
        <div class='col-xs-4'>
            <h4>
                <strong>
                    Score: {{$profile->score}}
                    Community Score: {{$profile->community_score}}
                </strong>
                <span class='community-score-tooltip' data-toggle='tooltip'
                  title='Community score determines rates how good of a community member you are. 
                  Invite your friends in Settings to raise your community score!'>
                    (?)
                </span>
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
