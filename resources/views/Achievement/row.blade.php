<?php
use App\Achievement;
use App\Follow;
use App\User;
if (Auth::user()){
    $has_user_completed_achievement = Achievement::has_user_completed_achievement($achievement->id);
    $is_user_following_achievement =
      count(Follow::where('achievement_id', $achievement->id)->where('user_id', Auth::user()->id)->get())>0;
    $can_user_vote_achievement_up_or_down =
      Achievement::can_user_vote_achievement_up_or_down($achievement->id);
    $is_this_on_their_bucket_list = Achievement::is_this_on_their_bucket_list($achievement->id);
}
    $is_achievement_passing_approval = Achievement::passing_approval($achievement->id);
?>
<tr class="
  @if ($achievement->status==1)
      approved-achievement
  @elseif ($achievement->status==0)
      denied-achievement
  @elseif ($achievement->status==2)
      pending-achievement
  @elseif ($achievement->status==3)
      inactive-achievement
  @elseif ($achievement->status==4)
      canceled-achievement
  @endif
  @if (Auth::user())
      @if ($has_user_completed_achievement)
          completed-achievement
      @endif
      @if ($is_user_following_achievement)
          followed-achievement
      @endif
      @if ($is_this_on_their_bucket_list)
          goal-achievement
      @endif
  @endif
  ">
    <td class='achievement achievement-score text-center col-xs-1'>
    @if (Auth::user())
        @if ($can_user_vote_achievement_up_or_down)
        <form method="POST" action="{{route('AchievementVote.store')}}" role='form' class='inline' >
                {{csrf_field()}}
                <input type='hidden' name='achievementID' value='{{$achievement->id}}' />
                <input type='hidden' name='voteUp' value="1" />
                <button type='submit' class='btn-link'>&uarr;</button>
        </form>
        @endif
        {{$achievement->score}}
        @if ($can_user_vote_achievement_up_or_down)
        <form method="POST" action="{{route('AchievementVote.store')}}" class='inline' >
            {{csrf_field()}}
            <input type='hidden' name='achievementID' value='{{$achievement->id}}' />
            <input type='hidden' name='voteUp' value="0" />
            <button type='submit' class='btn-link'> &darr;</button>
        </form>
        @endif
    @else
        {{$achievement->score}}
    @endif
    </td>
    <td
      title="Created by {{$achievement->user->username}} on
      @if (Auth::guest())
      {{date(Config::get('rla.timestamp_format') . ' e', strtotime($achievement->created_at))}}
      @elseif (Auth::user())
      {{ date(Config::get('rla.timestamp_format'), User::local_time(Auth::user()->timezone, strtotime($achievement->created_at)))}}
      @endif
      "
      class='achievement achievement-caption text-center col-xs-11 align-middle'>
        @if(Achievement::can_user_vote_on_proof($achievement->id))
        <span class='vote-available'>
            Vote Available!
        </span>
        @endif
        <a  class='achievement-link
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
            @if ($is_achievement_passing_approval===true)
            pass
            @elseif ($is_achievement_passing_approval===false)
            fail
            @endif
        @elseif ($achievement->status==3)
            inactive
        @endif
        '
        href="{{route('achievement.show', ['url'=> $achievement->url])}}">
            <div>
                {{ $achievement->name }}
            @if (Auth::user() && $has_user_completed_achievement)
                &#10004;
            @endif
            </div>
        </a>
        @if (substr($sort, 0, 4)=="date")
            {{date(Config::get('rla.date_format'), strtotime($achievement->created_at))}}
        @endif
    </td>
</tr>
