<?php use App\User; ?>
@extends('layouts.app')

@section('content')
<div>
<?php $old_date = 0; $old_time =0; ?>
@forelse ($timeline_items as $timeline_item)
    <?php 

    if (Auth::guest()){
    $date = date('m/d/y', strtotime($timeline->created_at));
    $time = date('H:i', strtotime($timeline_item->created_at));
  } else if (Auth::user()){
    $date = date('m/d/y', User::local_time(Auth::user()->timezone, strtotime($timeline_item->created_at)));
    $time = date('H:i', User::local_time(Auth::user()->timezone, strtotime($timeline_item->created_at))); 
  }
    ?>
    @if ($date!=$old_date)
        <h2>{{$date}}</h2>
    <?php $old_date = $date; ?>
    @endif
    @if ($time!=$old_time)
    <div>{{$time}}</div>
    <?php $old_time = $time; ?>
    @endif
    @if ($timeline_item->event=="new comment" || $timeline_item->event=="new proof vote comment")
        @include ("Timeline.comment")
    @elseif ($timeline_item->event=='new proof')
        <div class='margin-left'>
            @if ($timeline_item->proof->user_id==Auth::user()->id)
                You
            @else
                <a href="{{route('user.show', ['id'=>$timeline_item->proof->user_id])}}">{{$timeline_item->proof->user->username}}</a>
            @endif
              submitted a new proof for your achievement
              <a href="{{route('achievement.show', ['id'=>$timeline_item->proof->achievement_id])}}#proof{{$timeline_item->proof_id}}">"{{$timeline_item->proof->achievement->name}}"</a>.
        </div>
    @elseif (substr($timeline_item->event,0, 10)=="swing vote")
        <div class='margin-left'>
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
        <div class='margin-left'>
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
        <div class='margin-left'>
            You created a new achievement. (<a href="{{route('achievement.show', ['id'=>$timeline_item->achievement_id])}}">{{$timeline_item->achievement->name}}</a>)
        </div>
    @else 
    <?php var_dump($timeline_item->event); ?>
    @endif
@empty
<div class='center'>
Your timeline is empty. You need to create new achievements, comment or submit proof to existing achievements in order to fill your timeline. 
</div>
@endforelse
</div>
@endsection
