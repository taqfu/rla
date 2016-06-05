<?php use App\User; ?>
@extends('layouts.app')

@section('content')
<div>
<?php $old_date = 0; $old_time =0; ?>
@foreach ($timeline_items as $timeline_item)
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
        <h3>{{$date}}</h3>
    <?php $old_date = $date; ?>
    @endif
    @if ($time!=$old_time)
    <div>{{$time}}</div>
    <?php $old_time = $time; ?>
    @endif
    @if ($timeline_item->event=="new comment" || $timeline_item->event=="new proof vote comment")
        @include ("Timeline.comment")
    @else
    {{$timeline_item->event}}
    @endif
@endforeach
</div>
@endsection
