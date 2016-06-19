<?php
use App\User;
$point_caption = $profile->score!=1 ? "points" : "point";
?>
@extends('layouts.app')
@section('title')
 - {{$profile->username}} - Achievements
@endsection
@section('content')
@include ('User.menu', ['active'=>'profile'])
@include ('User.header')
<div class='margin-left'>
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
    
    <div class='margin-left user_profile_achievements'>
        <a  class='achievement_link' href="{{route('achievement.show', ['id'=>$proof->achievement->id])}}">{{$proof->achievement->name}}</a>
        (<a href="{{route('proof.show', ['id'=>$proof->id])}}">Proof</a>)  - <a href="{{route('user.show', ['id'=>$proof->achievement->user->id])}}">{{$proof->achievement->user->username}}</a>
    </div>
    @empty
    <div class='margin-left'>
        @if (Auth::user() && Auth::user()->id == $profile->id)
            You
        @else
            They
        @endif
         have not completed any achievements.
    </div>
    @endforelse
    
    
    <h3>Created Achievements</h3>
    @forelse($achievements as $achievement)
    
    <div class='margin-left user_profile_achievements'>
        <a  class='achievement_link' href="{{route('achievement.show', ['id'=>$achievement->id])}}">{{$achievement->name}}</a>
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
    </div>
    @empty
    <div class='margin-left'>
        @if (Auth::user() && Auth::user()->id == $profile->id)
            You
        @else
            They
        @endif
         have not created any achievements.
    </div>    
    @endforelse
    
    <h3>Followed Achievements</h3>
    @forelse($follows as $follow)
    <div class='margin-left user_profile_achievements'>
        <a class='achievement_link' href="{{route('achievement.show', ['id'=>$follow->achievement->id])}}">{{$follow->achievement->name}}</a>
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
    </div>
    @empty
    <div class='margin-left'>
        @if (Auth::user() && Auth::user()->id == $profile->id)
            You
        @else
            They
        @endif
         have not followed any achievements.
    </div>    
    @endforelse
</div>
@endsection
