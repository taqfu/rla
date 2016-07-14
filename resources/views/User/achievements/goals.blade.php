
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
 Bucket List
@endsection

@section('content')
@include ('User.header')
@include ('User.menu', ['active'=>'goals'])
<h3>
    Bucket List (Goals)
</h3>
<ul class='list-group'>
    @forelse($goals as $goal)
    <li class='list-group-item'>
        <a class='achievement-link' href="{{route('achievement.show', ['url'=>$goal->achievement->url])}}">{{$goal->achievement->name}}</a>
        @if ($goal->achievement->status==0)
            <span class='fail'>(Denied)</span>
        @elseif ($goal->achievement->status==1)
            <span class='pass'>(Approved)</span>
        @elseif ($goal->achievement->status==2)
            <span class='pending'>(Pending Approval)</span>
        @elseif ($goal->achievement->status==3)
            <span >(Unproven)</span>
        @endif
          - <a href="{{route('user.show', ['id'=>$goal->achievement->user_id])}}">{{$goal->achievement->user->username}}</a>
    </li>
    @empty
    <li class='list-group-item'>
        @if (Auth::user() && Auth::user()->id == $profile->id)
            You
        @else
            They
        @endif
         have not added any achievements to their bucket list.
    </li>
    @endforelse
</ul>
@endsection
