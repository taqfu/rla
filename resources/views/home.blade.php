<?php use App\User; ?>
@extends('layouts.app')

@section('content')
<div id='homepage'>
<?php
$old_date = 0;
$old_time =0;
?>
@forelse ($timeline_items as $timeline_item)
    <?php
        $timestamp = Auth::user()
          ? $timestamp = date('m/d/y h:i:sA', User::local_time(Auth::user()->timezone, strtotime($timeline_item->created_at)))
          : date('m/d/y h:i:sA e', strtotime($timeline_item->created_at));
    ?>
    @if ($timeline_item->event=="new comment" || $timeline_item->event=="new proof vote comment")
    <div class='timeline_container'>
        @include ("Timeline.comment")
    </div>
    @elseif ($timeline_item->event=='new proof')
    <div class='timeline_container'>
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
        <div class='notification margin-left'>
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
            @endif
            </p>
            <p>
                (<a href="{{route('achievement.show', ['url'=>$timeline_item->proof->achievement->url])}}#proof{{$timeline_item->proof_id}}">{{$timeline_item->proof->achievement->name}}</a>)
            </p>
        </div>
    </div>
    @elseif (substr($timeline_item->event,0, 10)=="swing vote")
    <div class='timeline_container'>
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
        <div class='notification margin-left'>
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
    </div>
    @elseif (substr($timeline_item->event, 0, 19 )=="change proof status" && $timeline_item->proof->status!=1)
    <div class='timeline_container'>
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
        <div class='notification margin-left'>
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

            @if (substr($timeline_item->event, -1, 1) == "1")
            @endif
        </div>
    </div>
    @elseif (substr($timeline_item->event, 0, 15)=="new achievement")
    <div class='timeline_container'>
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
        <div class='notification margin-left'>
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
    </div>
    @elseif (substr($timeline_item->event, 0, 25)=="change achievement status")
    <div class='timeline_container'>
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
        <div class='notification margin-left'>
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
    </div>
    @elseif (substr($timeline_item->event, 0, 10)=="new points")
    <div class='timeline_container'>
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
        <div class='notification margin-left'>
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
    </div>
    @elseif ($timeline_item->event == "cancel proof")
    <div class='timeline_container'>
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
        <div class='notification margin-left'>
            <p>
                You canceled <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">your proof</a> for the following achievement:
            </p>
            <p>
                (<a href="{{route('achievement.show', ['url'=>$timeline_item->proof->achievement->url])}}">{{$timeline_item->proof->achievement->name}}</a>)
            </p>
        </div>
    </div>
    @endif
@empty
<div class='center'>
Your timeline is empty. You need to create new achievements, comment or submit proof to existing achievements in order to fill your timeline.
</div>
@endforelse
</div>
@endsection
