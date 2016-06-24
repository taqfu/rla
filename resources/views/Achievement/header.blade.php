<?php
    use App\Achievement;
  use App\User;
?>
<div id='achievement-header' class='clearfix margin-bottom'>
    @if (Auth::guest())
    <div>
        Submitted:
        {{ date(Config::get('rla.timestamp_format') . ' e', strtotime($main->created_at))}}
    @elseif (Auth::user())
    <div class='col-xs-7'>
        Submitted:
        {{ date(Config::get('rla.timestamp_format'), User::local_time(Auth::user()->timezone, strtotime($main->created_at)))}}
        @endif
        by <a href="{{route('user.show', ['id'=>$main->user->id])}}">{{$main->user->username}}</a>
        @if ($main->status==2)
            - <span class='pending'>(Pending Approval)</span>
        @elseif ($main->status==0)
            - <span class='denied'>(Denied)</span>
        @elseif ($main->status==3)
            - Inactive(requires proof)
        @endif
        @if ((Auth::user() && Achievement::can_user_submit_proof($main->id))
                && ((Auth::user()->id==$main->user_id && $main->status==0)
                || (Auth::user()->id!=$main->user_id && $main->status!=2) || $main->status==3) )
            @include ('Proof.create', ['achievement_id'=>$main->id])
        @endif
    </div>
    @if (Auth::user())
    <div id='follow-menu' class='col-xs-5 text-right form-group'>
        <form method="POST" action="{{route('follow.update', ['id'=>$main->id])}}">
            @foreach ($errors->all() as $error)
            <div class='text-danger'>
                {{$error}}
            </div>
            @endforeach
            {{csrf_field()}}
            {{method_field('PUT')}}
            <input type='radio' id='unfollow' name='following' value="0"
              @if (!$following)
                checked
              @endif
              >
            <label for='unfollow'
              @if (!$following)
              class='text-info'
              @endif
              >
                Not Following
            </label>
            <input type='radio' id='follow' name='following' value="1"
              @if ($following)
                checked
              @endif
              >
            <label for='follow'
              @if ($following)
              class='text-info'
              @endif
              >
                Following
            </label>
        </form>
    </div>
    @endif
</div>
