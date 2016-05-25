<?php use App\Achievement; ?>
@extends('layouts.app')
@section('content')
@if (Auth::user())
    @include ('Achievement.create') 
@endif
<div style='margin-bottom:8px;'>
<input id='approved' type='checkbox'  class='filter' />
<label for='approved' class='approved filter'>Approved </label>
<input id='denied' type='checkbox' class='filter' />
<label for='denied' class='denied filter'>Denied </label>
<input id='pending' type='checkbox'  class='filter'>
<label for='pending' class='filter pending'>Pending </label>
@if (Auth::user())
<input id='complete' type='checkbox' class='filter'>
<label for='complete' class='complete filter'>Complete </label>
<input id='incomplete' type='checkbox' class='filter'>
<label for='incomplete' class='filter incomplete'>Incomplete </label>
@endif
</div>
@foreach ($achievements as $achievement)
    @if (Auth::user())
    <?php $has_user_completed_achievement = Achievement::has_user_completed_achievement($achievement->id); ?>
    @endif
    <div style='margin:12px;'>
    &nbsp;
    <div class='achievement 
        @if ($achievement->status==1)
            approved_achievement
        @elseif ($achievement->status==0)
            denied_achievement
        @elseif ($achievement->status==2)
            pending_achievement
        @endif
        @if (Auth::user())
            @if ($has_user_completed_achievement)
                complete_achievement
            @else
                incomplete_achievement
            @endif
        @endif
    '>
        <a  class='
        @if(Auth::user())
            @if ($has_user_completed_achievement)
                complete
            @else
                incomplete
            @endif
        @endif 
        @if ($achievement->status==0)
            denied
        @elseif ($achievement->status==1)
            approved
        @elseif ($achievement->status==2)
            pending
        @endif
        '
        href="{{route('achievement.show', ['id'=> $achievement->id])}}">
            {{ $achievement->name }}</a>  
        </div>
            <div style='float:left;width:110px;text-align:center;margin-right:8px;'>
        &nbsp;
        
        @if(Achievement::can_user_vote($achievement->id))
                Vote Available!
        @endif
        </div>
        <div style='float:left;clear:right;'>
            <a href="{{route('user.show', ['id'=>$achievement->created_by])}}">{{$achievement->user->name}}</a>
        </div>
    </div>
@endforeach
@endsection
