
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
@include ('User.header')
@include ('User.menu', ['active'=>'subscriptions'])
<h3>
    Followed Achievements
</h3>
<ul class='list-group'>
    @forelse($follows as $follow)
    <li class='list-group-item'>
        <a class='achievement-link' href="{{route('achievement.show', ['url'=>$follow->achievement->url])}}">{{$follow->achievement->name}}</a>
        @if ($follow->achievement->status==0)
            <span class='fail'>(Denied)</span>
        @elseif ($follow->achievement->status==1)
            <span class='pass'>(Approved)</span>
        @elseif ($follow->achievement->status==2)
            <span class='pending'>(Pending Approval)</span>
        @elseif ($follow->achievement->status==3)
            <span >(Unproven)</span>
        @endif
          - <a href="{{route('user.show', ['username'=>$follow->achievement->user->username])}}">{{$follow->achievement->user->username}}</a>
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
