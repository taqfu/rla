<?php use App\Achievement; ?>
@extends('layouts.app')
@section('content')
@if (Auth::user())
    @include ('Achievement.create') 
@endif
<div style='clear:both;'>
@foreach ($achievements as $achievement)
    <div>
        <a href="{{route('achievement.show', ['id'=> $achievement->id])}}">{{ $achievement->name }}</a>
        Created by <a href="{{route('user.show', ['id'=>$achievement->user->id])}}">{{$achievement->user->name}}</a>
        @if ($achievement->status==2)
        <span style='font-style:italic;'>
            (Pending Approval)
        </span>
        @endif
        @if (Achievement::can_user_vote($achievement->id))
            YO
        @endif
    </div>
@endforeach
</div>
@endsection
