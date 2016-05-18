<?php use App\Achievement; ?>
@extends('layouts.app')
@section('content')
@if (Auth::user())
    @include ('Achievement.create') 
@endif
<input id='approved' type='checkbox'  class='filter' />
<label for='approved' class='approved filter'>Approved </label>
<input id='denied' type='checkbox' class='filter' />
<label for='denied' class='denied filter'>Denied </label>
<input id='pending' type='checkbox'  class='filter'>
<label for='pending' class='filter pending'>Pending </label>
<input id='complete' type='checkbox' class='filter'>
<label for='complete' class='complete filter'>Complete </label>
<input id='incomplete' type='checkbox' class='filter'>
<label for='incomplete' class='filter incomplete'>Incomplete </label>

<div style='clear:both;'>
@foreach ($achievements as $achievement)
    <div class='
        @if ($achievement->status==1)
            approved_achievement
        @elseif ($achievement->status==0)
            denied_achievement
        @elseif ($achievement->status==2)
            pending_achievement
        @endif
        
    '>
        <a  class='
        @if (Achievement::has_user_completed_achievement($achievement->id))
            complete_achievement
        @else
            incomplete_achievement
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

            {{ $achievement->name }}</a> - 
        <a href="{{route('user.show', ['id'=>$achievement->created_by])}}">{{$achievement->user->name}}</a>
        
        @if(Achievement::can_user_vote($achievement->id))
            Vote Available!
        @endif
    </div>
@endforeach
</div>
@endsection
