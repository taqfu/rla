<?php use App\Achievement; ?>
@extends('layouts.app')
@section('content')
@if (Auth::user())
    @include ('Achievement.create') 
@endif
<div style='clear:both;'>
@foreach ($achievements as $achievement)
    <?php $can_user_vote = Achievement::can_user_vote($achievement->id); ?>
    <div>
        <a href="{{route('achievement.show', ['id'=> $achievement->id])}}">{{ $achievement->name }}</a> - 
        <a href="{{route('user.show', ['id'=>$achievement->created_by])}}">{{$achievement->user->name}}</a>
        
        @if ($achievement->status==0)
            <span style='color:red;'>Denied!</span>
        @elseif ($achievement->status==2)
        <span style='font-style:italic;'>
           
            @if ($can_user_vote)
                (Pending Approval - Vote Available!)
            @else
                (Pending Approval)
            @endif
        </span>
        @elseif ($achievement->status!=2 &&  $can_user_vote)
            Vote Available!
        @endif
    </div>
@endforeach
</div>
@endsection
