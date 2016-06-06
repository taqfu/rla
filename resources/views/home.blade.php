<?php use App\User; ?>
@extends('layouts.app')

@section('content')
<div id='homepage'>
<?php $old_date = 0; $old_time =0; ?>
@forelse ($timeline_items as $timeline_item)
    <?php

    if (Auth::guest()){
    $timestamp = date('m/d/y h:i:sA e', strtotime($timeline->created_at));
  } else if (Auth::user()){
    $timestamp = date('m/d/y h:i:sA', User::local_time(Auth::user()->timezone, strtotime($timeline_item->created_at)));
  }
    ?>
    <div>
    @if ($timeline_item->event=="new comment" || $timeline_item->event=="new proof vote comment")
        @include ("Timeline.comment")
    @elseif ($timeline_item->event=='new proof')
        <div class='timeline margin-left'>
            <span title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</span> - 
            @if ($timeline_item->proof->user_id==Auth::user()->id)
                You
            @else
                <a href="{{route('user.show', ['id'=>$timeline_item->proof->user_id])}}">{{$timeline_item->proof->user->username}}</a>
            @endif
              submitted a <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">new proof</a> for your achievement
              <a href="{{route('achievement.show', ['id'=>$timeline_item->proof->achievement_id])}}#proof{{$timeline_item->proof_id}}">"{{$timeline_item->proof->achievement->name}}"</a>.
        </div>
    @elseif (substr($timeline_item->event,0, 10)=="swing vote")
        <div class='timeline margin-left'>
            <span title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</span> - 
            {{$timeline_item->vote->user->username}} voted
            @if ($timeline_item->vote->vote_for)
                for
            @else
                against
            @endif
            <a href="{{route('proof.show', ['id'=>$timeline_item->vote->proof_id])}}">your proof</a>
            for <a href="{{route('achievement.show', ['id'=>$timeline_item->vote->achievement_id])}}">"{{$timeline_item->vote->achievement->name}}"</a>.

            It is now
            @if ($timeline_item->event=='swing vote - approved')
              passing
            @elseif ($timeline_item->event=='swing vote - denied')
              failing
            @endif
            .
        </div>
    @elseif (substr($timeline_item->event, 0, 19 )=="change proof status")
        <div class='timeline margin-left'>
            <span title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</span> - 
            <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">Your proof</a> for
            <a href="{{route('achievement.show', ['id'=>$timeline_item->proof->achievement_id])}}">"{{$timeline_item->proof->achievement->name}}"</a> has been
            @if (substr($timeline_item->event, -1, 1) == "1")
              approved
            @elseif (substr($timeline_item->event, -1, 1) == "0")
              denied
            @endif
            .
        </div>
    @elseif ($timeline_item->event=="new achievement")
        <div class='timeline margin-left'>
            <span title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</span> - 
            You created a new achievement. (<a href="{{route('achievement.show', ['id'=>$timeline_item->achievement_id])}}">{{$timeline_item->achievement->name}}</a>)
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="{{route('achievement.show', ['id'=>$timeline_item->achievement_id])}}" 
              data-text="I just created a new achievement! '{{substr($timeline_item->achievement->name, 0, 32)}}'
              @if (strlen($timeline_item->achievement->name)>32)
              ...
              @endif'" 
              data-via="doit_proveit">Tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        </div>
    @elseif (substr($timeline_item->event, 0, 25)=="change achievement status")
        <div class='margin-left'>
            <span title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</span> - 
            The achievement you created
            <a href="{{route('achievement.show', ['id'=>$timeline_item->achievement_id])}}">{{$timeline_item->achievement->name}}</a>
            @if (substring($timeline_item->event, -1, 1)=="0")
                has failed approval.
            @elseif (substring($timeline_item->event, -1, 1)=="1")
                is now approved.
            @elseif (substring($timeline_item->event, -1, 1)=="2")
                is currently under approval.
            @endif
        </div>
    @else
    <?php var_dump($timeline_item->event); ?>
    @endif
    </div>
@empty
<div class='center'>
Your timeline is empty. You need to create new achievements, comment or submit proof to existing achievements in order to fill your timeline.
</div>
@endforelse
</div>
@endsection
