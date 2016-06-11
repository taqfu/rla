<?php
use App\User;
    $point_caption = $profile->score!=1 ? "points" : "point";
?>
@extends('layouts.app')
@section('title')
 - {{$profile->username}}
@endsection
@section('content')
@if (Auth::user() && Auth::user()->id == $profile->id)
	@include ('User.menu', ['active'=>'profile'])
@elseif (Auth::user() && Auth::user()->id != $profile->id)
	<h1>{{$profile->username}}</h1>
    <h3 class='margin-left'>{{$profile->score}} {{$point_caption}}</h3>
   	<a  class='margin-left' href="{{route('new_message', ['id'=>$profile->id])}}">Send Message</a>
@else
	<h1>{{$profile->username}}</h1>
    <h3 class='margin-left'>{{$profile->score}} {{$point_caption}}</h3>
@endif
<h3>Completed Achievements</h3>
<?php $old_date = 0; ?>
@forelse ($proofs as $proof)
    <?php
    if (Auth::guest()){
    $date = date('m/d/y', strtotime($proof->created_at));
  } else if (Auth::user()){
    $date = date('m/d/y', User::local_time(Auth::user()->timezone, strtotime($proof->created_at)));
  }
  ?>
   <!--
    @if ($old_date!=$date)
        <h3>{{$date}}</h3>
        <?php $old_date = $date; ?>
    @endif
    -->

<div class='margin-left'>
    <a  class='
        @if ($proof->achievement->status==0)
            denied
        @elseif ($proof->achievement->status==1)
            approved
        @elseif ($proof->achievement->status==2)
            pending
        @elseif ($proof->achievement->status==3)
            inactive
        @endif
    ' href="{{route('achievement.show', ['id'=>$proof->achievement->id])}}">{{$proof->achievement->name}}</a>
    (<a href="{{route('proof.show', ['id'=>$proof->id])}}">Proof</a>)  - <a href="{{route('user.show', ['id'=>$proof->achievement->user->id])}}">{{$proof->achievement->user->username}}</a>
</div>
@empty
You have not completed any achievements.

@endforelse
@endsection
