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
@include ('User.menu', ['active'=>'claimed'])
<h3>Claimed Achievements</h3>
<ul class='list-group'>
    @forelse ($claims as $claim)
        <?php
        if (Auth::guest()){
        $date = date(Config::get('date_format'), strtotime($claim->created_at));
      } else if (Auth::user()){
        $date = date(Config::get('date_format'), User::local_time(Auth::user()->timezone, strtotime($claim->created_at)));
      }
      ?>
    <li class='list-group-item'>
        <a  class='achievement-link' href="{{route('achievement.show', ['url'=>$claim->achievement->url])}}">{{$claim->achievement->name}}</a>
        - <a href="{{route('user.show', ['username'=>$claim->achievement->user->username])}}">{{$claim->achievement->user->username}}</a>
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
