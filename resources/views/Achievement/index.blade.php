<?php
  use App\Achievement;
  use App\User;
?>
@extends('layouts.app')
@section('title')
@endsection
@section('content')
@if (Auth::user())
    @include ('Achievement.create')
@else
<div id='guest_warning' class='center'>
    <a href="{{url('/register')}}">Register</a>
     or
    <a href="{{url('/login')}}">login</a>
     to create new achievements!
</div>
@endif
<div id='achievement_filters' class='margin-bottom center margin-bottom' >
    <div class='approved'>
        <label for='approved' class='approved filter'>Approved </label>
        <input id='approved' type='checkbox'  class='filter' />
    </div>
    <div class='denied'>
        <label for='denied' class='denied filter'>Denied </label>
        <input id='denied' type='checkbox' class='filter' />
    </div>
    <div class='pending'>
        <label for='pending' class='filter pending'>Pending </label>
        <input id='pending' type='checkbox'  class='filter'>
    </div>
    <div class='inactive'>
        <label for='inactive' class='filter inactive'>Inactive </label>
        <input id='inactive' type='checkbox' class='filter'>
    </div>
    @if (Auth::user())
    <div class='complete'>
        <label for='complete' class='complete filter'>Complete </label>
        <input id='complete' type='checkbox' class='filter'>
    </div>
    @endif
</div>
<div class='center'>
<table class='inline'>
@foreach ($achievements as $achievement)
    @if (Auth::user())
    <?php $has_user_completed_achievement = Achievement::has_user_completed_achievement($achievement->id); ?>
    @endif
        <tr> <td
          title="Created by {{$achievement->user->username}} on
          @if (Auth::guest())
          {{date('m/d/y h:i:sA e', strtotime($achievement->created_at))}}
          @elseif (Auth::user())
          {{ date('m/d/y h:i:sA', User::local_time(Auth::user()->timezone, strtotime($achievement->created_at)))}}
          @endif
          "
          class='achievement
            @if ($achievement->status==1)
                approved_achievement
            @elseif ($achievement->status==0)
                denied_achievement
            @elseif ($achievement->status==2)
                pending_achievement
            @elseif ($achievement->status==3)
                inactive_achievement
            @endif
            @if (Auth::user())
                @if ($has_user_completed_achievement)
                    complete_achievement
                @endif
            @endif
        '>
            <a  class='
            @if(Auth::user())
                @if ($has_user_completed_achievement)
                    complete
                @endif
            @endif
            @if ($achievement->status==0)
                denied
            @elseif ($achievement->status==1)
                approved
            @elseif ($achievement->status==2)
                pending
            @elseif ($achievement->status==3)
                inactive
            @endif
            '
            href="{{route('achievement.show', ['id'=> $achievement->id])}}">
                <div>{{ $achievement->name }}</div></a>

            @if(Achievement::can_user_vote_on_proof($achievement->id))
            <span class='vote_available'>
            <a href="{{route('achievement.show', ['id'=> $achievement->id])}}">Vote Available!</a>
            </span>
            @endif
    </td></tr>
@endforeach
</table>
</div>
@endsection
