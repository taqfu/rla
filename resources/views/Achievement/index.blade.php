<?php
  use App\Achievement;
  use App\Follow;
  use App\User;
?>
@extends('layouts.app')
@section('title')
    - Achievement Listing
@endsection
@section ('head')
     <meta name="csrf-token" content="{{ csrf_token() }}">
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
<div id='achievement_filters' class='margin-bottom center' >
    &nbsp;
    <div class='clear'>
        Status:
        <label for='approved' class='approved filter'>Approved
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has been approved and multiple people can submit proof for it at the same time. Voting is only open to those that have already completed the achievement.'>
                (?)
            </span>
            <input id='approved' type='checkbox'  class='filter' />
        </label>
        <label for='denied' class='denied filter'>Denied
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has been denied approval. One person may submit approval at a time and anyone can vote for its approval.'>
                (?)
            </span>
            <input id='denied' type='checkbox' class='filter inactive-filter' />
        </label>
        <label for='pending' class='filter pending'>Pending Approval
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement is pending approval. Anyone may vote to determine whether it passes approval.'>
                (?)
            </span>
            <input id='pending' type='checkbox'  class='filter'>
        </label>
        <label for='inactive' class='filter inactive'>Unproven
            <span class='filter-tooltip' data-toggle='tooltip'
              title='This achievement has no proofs submitted to it. Submit a proof for approval.'>
                (?)
            </span>
            <input id='inactive' type='checkbox' class='filter inactive-filter'>
        </label>
    </div>
    <div class='margin-top'>
        <p><span class='complete_achievement'>Completed achievements black background.</span></p> 
        <p class='followed'>Followed achievements underlined.</p>
    </div>
</div>
@include  ('Achievement.sort', ['page_type'=>'listing'])
<div class='center'>
<table class='inline'>
@foreach ($achievements as $achievement)
    @if (Auth::user())
    <?php 
    $has_user_completed_achievement = Achievement::has_user_completed_achievement($achievement->id); 
    $is_user_following_achievement = count(Follow::where('achievement_id', $achievement->id)->where('user_id', Auth::user()->id)->get())>0;
    ?>
    @endif
        <tr class="
        @if ($achievement->status==0 || $achievement->status==3 )
            hidden
        @endif
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
                @if ($is_user_following_achievement)
                    followed_achievement
                @endif
            @endif
        ">
        <td class='achievement' style='padding:8px;font-size:1.5em;'>
        @if (Auth::user())
        <?php $can_user_vote = Achievement::can_user_vote($achievement->id); ?>
            @if ($can_user_vote)
            <form method="POST" action="{{route('AchievementVote.store')}}" style='display:inline;'>
            {{csrf_field()}}
            <input type='hidden' name='achievementID' value='{{$achievement->id}}' />
            <input type='hidden' name='voteUp' value="1" />
            <input type='submit' value='&uarr;' class='text_button' />
            </form>
            @endif
            {{$achievement->score}}
            @if ($can_user_vote)
            <form method="POST" action="{{route('AchievementVote.store')}}" style='display:inline;'>
            {{csrf_field()}}
            <input type='hidden' name='achievementID' value='{{$achievement->id}}' />
            <input type='hidden' name='voteUp' value="0" />
            <input type='submit' value='&darr;' class='text_button' />
            </form>
            @endif
        @else
            {{$achievement->score}}
        @endif
        </td>
        <td
          title="Created by {{$achievement->user->username}} on
          @if (Auth::guest())
          {{date('m/d/y h:i:sA e', strtotime($achievement->created_at))}}
          @elseif (Auth::user())
          {{ date('m/d/y h:i:sA', User::local_time(Auth::user()->timezone, strtotime($achievement->created_at)))}}
          @endif
          "
          class='achievement
        '>
            <a  class='
            @if(Auth::user())
                @if ($has_user_completed_achievement)
                    complete
                @endif
                @if ($is_user_following_achievement)
                    followed
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
