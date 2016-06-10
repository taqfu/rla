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
<div id='achievement_filters' class='margin-bottom center' >
    &nbsp;
    <div class='clear' style='display:block;'>
    Status:
        <div class='approved'>
            <label for='approved' class='approved filter'>Approved  
                <span class='filter-tooltip' data-toggle='tooltip' 
                  title='This achievement has been approved and multiple people can submit proof for it at the same time. Voting is only open to those that have already completed the achievement.'>
                    (?)
                </span>
            </label>
            <input id='approved' type='checkbox'  class='filter' />
        </div>
        <div class='denied'>
            <label for='denied' class='denied filter'>Denied                 
                <span class='filter-tooltip' data-toggle='tooltip' 
                  title='This achievement has been denied approval. One person may submit approval at a time and anyone can vote for its approval.'>
                    (?)
                </span>
            </label>
            <input id='denied' type='checkbox' class='filter inactive-filter' />
        </div>
        <div class='pending'>
            <label for='pending' class='filter pending'>Pending Approval
                <span class='filter-tooltip' data-toggle='tooltip' 
                  title='This achievement is pending approval. Anyone may vote to determine whether it passes approval.'>
                    (?)
                </span>
            </label>
            <input id='pending' type='checkbox'  class='filter'>
        </div>
        <div class='inactive'>
            <label for='inactive' class='filter inactive'>Unproven
                <span class='filter-tooltip' data-toggle='tooltip' 
                  title='This achievement has no proofs submitted to it. Submit a proof for approval.'>
                    (?)
                </span>
            </label>
            <input id='inactive' type='checkbox' class='filter inactive-filter'>
        </div>
    </div>
    @if (Auth::user())
    <div class='clear' style='display:block;margin-top:16px;'>
        &nbsp;
        <div class='complete'>
            <label for='complete' class='complete filter'>Completed By You </label>
            <input id='complete' type='checkbox' class='filter'>
        </div>
    </div>
    @endif
</div>
<div class='center'>
<table class='inline'>
@foreach ($achievements as $achievement)
    @if (Auth::user())
    <?php $has_user_completed_achievement = Achievement::has_user_completed_achievement($achievement->id); ?>
    @endif
        <tr class="
        @if ($achievement->status==0 || $achievement->status==3)
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
            @endif
        ">
        @if (Auth::user())
        <?php $can_user_vote = Achievement::can_user_vote($achievement->id); ?>
        <td class='achievement' style='padding:8px;font-size:1.5em;'>
            @if ($can_user_vote)        
            <form method="POST" action="{{route('AchievementVote.store')}}" style='display:inline;'>
            {{csrf_field()}}
            <input type='hidden' name='achievementID' value='{{$achievement->id}}' />
            <input type='hidden' name='voteUp' value="1" />
            <input type='submit' value='&uarr;' class='text_button' />
            </form>
            @endif
            {{$achievement->tally}}
            @if ($can_user_vote)
            <form method="POST" action="{{route('AchievementVote.store')}}" style='display:inline;'>
            {{csrf_field()}}
            <input type='hidden' name='achievementID' value='{{$achievement->id}}' />
            <input type='hidden' name='voteUp' value="0" />
            <input type='submit' value='&darr;' class='text_button' />
            </form>
            @endif
        </td>
        @endif
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
