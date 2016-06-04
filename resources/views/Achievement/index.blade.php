<?php
  use App\Achievement;
  use App\User;
?>
@extends('layouts.app')
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
<div class='margin-bottom center margin-bottom' >
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
<div class='center'>
<table class='inline'>
@foreach ($achievements as $achievement)
    @if (Auth::user())
    <?php $has_user_completed_achievement = Achievement::has_user_completed_achievement($achievement->id); ?>
    @endif
        <tr> <td
          title="Created by {{$achievement->user->username}} on
          @if (Auth::guest())
          {{date('m/d/y g:i:s', strtotime($achievement->created_at))}}
          @elseif (Auth::user())
          {{ date('m/d/y g:i:s', User::local_time(Auth::user()->timezone, strtotime($achievement->created_at)))}}
          @endif
          "
          class='
            @if ($achievement->id == $last_achievement->id)
                last_achievement
            @else
                achievement //changed
            @endif
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

            @if(Achievement::can_user_vote($achievement->id))
            <span class='vote_available'>
            <a href="{{route('achievement.show', ['id'=> $achievement->id])}}">Vote Available!</a>
            </span>
            @endif
    </td></tr>
@endforeach
</table>
</div>
@endsection
