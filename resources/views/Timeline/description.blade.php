<?php

use App\User;
    $timestamp = Auth::user()
      ? $timestamp = date(Config::get('rla.timestamp_format'), User::local_time(Auth::user()->timezone, strtotime($timeline_item->created_at)))
      : date(Config::get('rla.timestamp_format') . ' e', strtotime($timeline_item->created_at));
?>
@if ($timeline_item->event=="new comment" || $timeline_item->event=="new proof vote comment")
    @include ("Timeline.comment")
@elseif ($timeline_item->event=='new proof')
    <div title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div >
        <p>
        @if ($timeline_item->proof->user_id==Auth::user()->id)
            You
        @else
            <a href="{{route('user.show', ['id'=>$timeline_item->proof->user_id])}}">{{$timeline_item->proof->user->username}}</a>
        @endif
          submitted a <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">new proof</a> for
        @if ($timeline_item->proof->achievement->user_id!=Auth::user()->id)
            an achievement.
        @else
            your achievement.
        @endif
        </p>
        <p>
            (<a href="{{route('achievement.show', ['url'=>$timeline_item->proof->achievement->url])}}#proof{{$timeline_item->proof_id}}">{{$timeline_item->proof->achievement->name}}</a>)
        </p>
    </div>
@elseif (substr($timeline_item->event,0, 10)=="swing vote")
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div >
        {{$timeline_item->vote->user->username}} voted
        @if ($timeline_item->vote->vote_for)
            for
        @else
            against
        @endif
        <a href="{{route('proof.show', ['id'=>$timeline_item->vote->proof_id])}}">your proof</a>
        for <a href="{{route('achievement.show', ['url'=>$timeline_item->vote->achievement->url])}}">"{{$timeline_item->vote->achievement->name}}"</a>.

        It is now
        @if ($timeline_item->event=='swing vote - approved')
          passing
        @elseif ($timeline_item->event=='swing vote - denied')
          failing
        @endif
        .
    </div>
@elseif (substr($timeline_item->event, 0, 19 )=="change proof status" )
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div >
        @if ($timeline_item->proof->user_id==Auth::user()->id)
        <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">Your proof</a>
        @else
            @if (substr($timeline_item->proof->user->username, -1, 1)=="s")
            <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">{{$timeline_item->proof->user->username}}' proof</a>
            @else
            <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">{{$timeline_item->proof->user->username}}'s proof</a>
            @endif
        @endif
         for
        <a href="{{route('achievement.show', ['url'=>$timeline_item->proof->achievement->url])}}">"{{$timeline_item->proof->achievement->name}}"</a> has been
        @if (substr($timeline_item->event, -1, 1) == "1")
          approved
        @elseif (substr($timeline_item->event, -1, 1) == "0")
          denied
        @endif
        .

    </div>
@elseif (substr($timeline_item->event, 0, 15)=="new achievement")
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div >
        <p>
        You created a new achievement.
        </p>
        @if($timeline_item->event=="new achievement no proof")
            <p>(Unfortunately, you provided no proof, so its inactive.)</p>
        @endif
        <p>
            (<a href="{{route('achievement.show', ['url'=>$timeline_item->achievement->url])}}">{{$timeline_item->achievement->name}}</a>)
        </p>
    </div>
@elseif (substr($timeline_item->event, 0, 25)=="change achievement status")
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div >
        The achievement you created
        <a href="{{route('achievement.show', ['url'=>$timeline_item->achievement->url])}}">"{{$timeline_item->achievement->name}}"</a>
        @if (substr($timeline_item->event, -1, 1)=="0")
            has failed approval.
        @elseif (substr($timeline_item->event, -1, 1)=="1")
            is now approved.
        @elseif (substr($timeline_item->event, -1, 1)=="2")
            is currently under approval.
        @endif
    </div>
@elseif (substr($timeline_item->event, 0, 10)=="new points")
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div >
    @if (substr($timeline_item->event, -26) == "owned achievement complete")
        <a href="{{route('user.show', ['id'=>$timeline_item->proof->user_id])}}">{{$timeline_item->proof->user->username}}</a> completed the achievement you created.

            You gained a point! You now have {{substr($timeline_item->event, 11, (strlen($timeline_item->event)-26)-12)}} points.
        <p>
            (<a href="{{route('achievement.show', ['url'=>$timeline_item->proof->achievement->url])}}">
                {{$timeline_item->proof->achievement->name}}
            </a>)
        </p>
    @elseif (substr($timeline_item->event, -14)=="proof complete")
        Your proof was approved!
        For completing
        <a href="{{route('achievement.show', ['url'=>$timeline_item->proof->achievement->url])}}">"{{$timeline_item->proof->achievement->name}}"</a>,
        you received  {{substr($timeline_item->event, 10, (strlen($timeline_item->event)-(14+10)))}} points.
    @endif
    </div>
@elseif ($timeline_item->event == "cancel proof")
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div >
        <p>
            You canceled <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">your proof</a> for the following achievement:
        </p>
        <p>
            (<a href="{{route('achievement.show', ['url'=>$timeline_item->proof->achievement->url])}}">{{$timeline_item->proof->achievement->name}}</a>)
        </p>
    </div>
@elseif ($timeline_item->event=="claim achievement")
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div>
        @if ($timeline_item->claim->user_id==Auth::user()->id)
            You claimed to have completed an achievement and added {{$timeline_item->claim->points}} points to your claim score.
        @else
            <a href="{{route('user.show', ['id'=>$timeline_item->claim->user_id])}}">
                {{$timeline_item->claim->user->username}}
            </a>
             claimed to have completed this achievement.
        @endif
    </div>
    <div>
        (<a href="{{route('achievement.show', ['url'=>$timeline_item->claim->achievement->url])}}">
            {{$timeline_item->claim->achievement->name}}
        </a>)
    </div>
@elseif ($timeline_item->event=="new goal")
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div>
        You added a new achievement to your bucket list.
    </div>
    <div>
        (<a href="{{route('achievement.show', ['url'=>$timeline_item->achievement->url])}}">
        {{$timeline_item->achievement->name}}
        </a>)    
    </div>

@elseif ($timeline_item->event=="new claim")
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div>
        You claimed to have completed an achievement.
    </div>
    <div>
        (<a href="{{route('achievement.show', ['url'=>$timeline_item->achievement->url])}}">
        {{$timeline_item->achievement->name}}
        </a>)    
    </div>    
@else
    {{$timeline_item->event}}
@endif
