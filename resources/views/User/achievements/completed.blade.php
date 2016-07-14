<?php
use App\User;
?>
@extends('layouts.app')

@section('title')
 - {{$profile->username}}
@if (substr($profile->username, -1)=="s")
'
@else
's
@endif
 completed achievements
@endsection

@section('content')
@include ('User.header')
@include ('User.menu', ['active'=>'completed'])
<h3>Completed Achievements</h3>
<ul class='list-group'>
    @forelse ($proofs as $proof)
        <?php
        if (Auth::guest()){
        $date = date(Config::get('date_format'), strtotime($proof->created_at));
      } else if (Auth::user()){
        $date = date(Config::get('date_format'), User::local_time(Auth::user()->timezone, strtotime($proof->created_at)));
      }
      ?>
    <li class='list-group-item'>
        <a  class='achievement-link' href="{{route('achievement.show', ['url'=>$proof->achievement->url])}}">{{$proof->achievement->name}}</a>
        (<a href="{{route('proof.show', ['id'=>$proof->id])}}">Proof</a>)  - <a href="{{route('user.show', ['username'=>$proof->achievement->user->username])}}">{{$proof->achievement->user->username}}</a>
    </li>
    @empty
    <li class='list-group-item'>
        @if (Auth::user() && Auth::user()->id == $profile->id)
            You
        @else
            They
        @endif
         have not completed any achievements.
    </li>
    @endforelse
</ul>

@endsection
