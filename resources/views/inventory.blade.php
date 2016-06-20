<?php
  use App\Achievement;
  use App\Follow;
  use App\User;
?>
@extends('layouts.app')
@section('title') 
 - Your Achievements
@endsection
@section('content')
@include ('Achievement.filter', ['type'=>'inventory'])
@include ('Achievement.sort', ['page_type'=>'inventory'])
<div id='inventory' class='center'>
    <table class='center-margin'>
    @foreach ($achievements as $achievement)
        @if (Auth::user())
        <?php 
        $has_user_completed_achievement = Achievement::has_user_completed_achievement($achievement->id); 
        $is_user_following_achievement = count(Follow::where('achievement_id', $achievement->id)->where('user_id', Auth::user()->id)->get())>0;
        ?>
        @endif
            <tr class="
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
            <td class='achievement achievement-score'>
            @if (Auth::user())
            <?php $can_user_vote = Achievement::can_user_vote($achievement->id); ?>
                @if ($can_user_vote)
                <form method="POST" action="{{route('AchievementVote.store')}}" class='inline left'>
                {{csrf_field()}}
                <input type='hidden' name='achievementID' value='{{$achievement->id}}' />
                <input type='hidden' name='voteUp' value="1" />
                <input type='submit' value='&uarr;' class='text_button' />
                </form>
                @endif
                {{$achievement->score}}
                @if ($can_user_vote)
                <form method="POST" action="{{route('AchievementVote.store')}}" class='inline right'>
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
              class='achievement achievement-caption
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
