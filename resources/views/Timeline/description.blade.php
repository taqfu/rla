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
        @if (Auth::user() && $timeline_item->proof->user_id==Auth::user()->id)
            You
        @else
            <a href="{{route('user.show', ['username'=>$timeline_item->proof->user->username])}}">{{$timeline_item->proof->user->username}}</a>
        @endif
          submitted a <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">new proof</a> for
        @if (Auth::user() && $timeline_item->proof->achievement->user_id!=Auth::user()->id)
            an 
        @else
            your
        @endif
        achievement
        @if ($timeline_item->proof->status==4)
            then  cancelled it.
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
        @if (Auth::user() && $timeline_item->proof->user_id==Auth::user()->id)
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
        @if (Auth::user() && Auth::user()->id == $timeline_item->user_id)
        You
        @else
        <a href="{{route('user.show', ['username'=>$timeline_item->achievement->user->username])}}">
            {{$timeline_item->achievement->user->username}}
        </a>
        @endif
         created a new achievement.
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
        <a href="{{route('user.show', ['username'=>$timeline_item->proof->user->username])}}">{{$timeline_item->proof->user->username}}</a> completed the achievement 
        @if (Auth::user() && Auth::user()->id==$timeline_item->user_id)
            you 
        @else
        <a href="{{route('user.show', ['username'=>$timeline_item->achievement->user->username])}}">
            {{$timeline_item->achievement->user->username}}
        </a>
        @endif
        created and 
        @if (Auth::user() && Auth::user()->id==$timeline_item->user_id)
            you 
        @else
        <a href="{{route('user.show', ['username'=>$timeline_item->achievement->user->username])}}">
            {{$timeline_item->achievement->user->username}}
        </a>
        @endif

            gained a point! ({{substr($timeline_item->event, 11, (strlen($timeline_item->event)-26)-12)}} points)
        <p>
            (<a href="{{route('achievement.show', ['url'=>$timeline_item->proof->achievement->url])}}">
                {{$timeline_item->proof->achievement->name}}
            </a>)
        </p>
    @elseif (substr($timeline_item->event, -14)=="proof complete")
        @if (Auth::user() && Auth::user()->id==$timeline_item->user_id)
            Your 
        @else
        <a href="{{route('user.show', ['username'=>$timeline_item->achievement->user->username])}}">
            @if (substr($timeline_item->achievement->user->username, -1, 1)=="s")
                {{$timeline_item->achievement->user->username}}'
            @else
                {{$timeline_item->achievement->user->username}}'s
            @endif
        </a>
        @endif
        
         proof was approved!
        For completing
        <a href="{{route('achievement.show', ['url'=>$timeline_item->proof->achievement->url])}}">"{{$timeline_item->proof->achievement->name}}"</a>,
        @if (Auth::user() && Auth::user()->id==$timeline_item->user_id)
            you 
        @else
        <a href="{{route('user.show', ['username'=>$timeline_item->achievement->user->username])}}">
            {{$timeline_item->proof->user->username}}
        </a>
        @endif
        received  {{substr($timeline_item->event, 10, (strlen($timeline_item->event)-(14+10)))}} points.
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
@elseif ($timeline_item->event=="new goal")
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div>
        @if (Auth::user() && $timeline_item->user_id == Auth::user()->id)
        You
        @else
        <a href="{{route('user.show', ['username'=>$timeline_item->goal->user->username])}}">
            {{$timeline_item->goal->user->username}}
        </a>
        @endif
        added a new achievement to 
        @if (Auth::user() && $timeline_item->user_id==Auth::user()->id)
        your
        @else
        their
        @endif
        bucket list.
    </div>
    @if ($timeline_item->goal->canceled_at!=0)
    <div>    
        Canceled {{interval($timeline_item->goal->canceled_at, "now")}} ago
    </div>
    @endif
    <div>
        (<a href="{{route('achievement.show', ['url'=>$timeline_item->achievement->url])}}">
        {{$timeline_item->achievement->name}}
        </a>)
    </div>

@elseif ($timeline_item->event=="new claim")
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div>
    @if (Auth::user() && Auth::user()->id==$timeline_item->user_id)
    You
    @else
    <a href="{{route('user.show', ['username'=>$timeline_item->claim->user->username])}}">
        {{$timeline_item->claim->user->username}}
    </a>
    @endif
     claimed to have completed an achievement.
    </div>
    @if ($timeline_item->claim->canceled_at!=0)
    <div>    
        Canceled {{interval($timeline_item->claim->canceled_at, "now")}} ago
    </div>
    @endif
    <div>
        (<a href="{{route('achievement.show', ['url'=>$timeline_item->achievement->url])}}">
        {{$timeline_item->achievement->name}}
        </a>)
    </div>
     
@elseif ($timeline_item->event=="new story")
    <div  title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
    <div>
        @if ($timeline_item->user_id == Auth::user()->id)
            You
        @else
            <a href="{{route('user.show', ['username'=>$timeline_item->user->username])}}">
                {{$timeline_item->user->username}}
            </a>
        @endif
        posted a story for 
        @if ($timeline_item->user_id == Auth::user()->id)
            your
        @else
            their
        @endif
        @if ($timeline_item->proof_id>0)
            proof
        @elseif ($timeline_item->claim_id>0)
            claim
        @elseif ($timeline_item->goal_id>0)
            goal
        @endif
        for an achievement.
    </div>
    <div>
        <a href="{{route('achievement.show', ['url'=>$timeline_item->achievement->url])}}">
            ({{$timeline_item->achievement->name}})
        </a>
    </div>
    @include ('Story.show', ['story'=>$timeline_item->story])
@else
    {{$timeline_item->event}}
@endif
