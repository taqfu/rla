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
 achievements
@endsection

@section('content')
@include ('User.menu', ['active'=>'profile'])
@include ('User.header')
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
        <a  class='achievement-link' href="{{route('achievement.show', ['id'=>$proof->achievement->id])}}">{{$proof->achievement->name}}</a>
        (<a href="{{route('proof.show', ['id'=>$proof->id])}}">Proof</a>)  - <a href="{{route('user.show', ['id'=>$proof->achievement->user->id])}}">{{$proof->achievement->user->username}}</a>
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
<h3>
    Created Achievements
</h3>
<ul class='list-group'>
    @forelse($achievements as $achievement)
    <li class='list-group-item'>
        <a  class='achievement-link' href="{{route('achievement.show', ['id'=>$achievement->id])}}">{{$achievement->name}}</a>
        @if ($achievement->status==0)
            <span class='fail'>(Denied)</span>
        @elseif ($achievement->status==1)
            <span class='pass'>(Approved)</span>
        @elseif ($achievement->status==2)
            <span class='pending'>(Pending Approval)</span>
        @elseif ($achievement->status==3)
            <span class='unproven'>(Unproven)</span>
        @endif
          - <a href="{{route('user.show', ['id'=>$achievement->user_id])}}">{{$achievement->user->username}}</a>
    </li>
    @empty
    <li class='list-group-item'>
        @if (Auth::user() && Auth::user()->id == $profile->id)
            You
        @else
            They
        @endif
         have not created any achievements.
    </li>
    @endforelse
</ul>
<h3>
    Followed Achievements
</h3>
<ul class='list-group'>
    @forelse($follows as $follow)
    <li class='list-group-item'>
        <a class='achievement-link' href="{{route('achievement.show', ['id'=>$follow->achievement->id])}}">{{$follow->achievement->name}}</a>
        @if ($follow->achievement->status==0)
            <span class='fail'>(Denied)</span>
        @elseif ($follow->achievement->status==1)
            <span class='pass'>(Approved)</span>
        @elseif ($follow->achievement->status==2)
            <span class='pending'>(Pending Approval)</span>
        @elseif ($follow->achievement->status==3)
            <span >(Unproven)</span>
        @endif
          - <a href="{{route('user.show', ['id'=>$follow->achievement->user_id])}}">{{$follow->achievement->user->username}}</a>
    </li>
    @empty
    <li class='list-group-item'>
        @if (Auth::user() && Auth::user()->id == $profile->id)
            You
        @else
            They
        @endif
         have not followed any achievements.
    </li>
    @endforelse
</ul>
@endsection
