
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
 created achievements
@endsection

@section('content')
@include ('User.menu', ['active'=>'created'])
@include ('User.header')
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
@endsection
