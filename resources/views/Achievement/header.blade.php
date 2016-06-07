<?php
  use App\User;
 ?>
<h1 class='
    @if ($main->status==0)
        denied
    @elseif ($main->status==1)
        approved
    @elseif ($main->status==2)
        pending
    @elseif ($main->status==3)
        inactive
    @endif
'>
    {{$main->name }}
</h1>
<div id='header_info'>
    Submitted:
    @if (Auth::guest())
    {{ date('m/d/y h:i:sA e', strtotime($main->created_at))}}
    @elseif (Auth::user())
    {{ date('m/d/y h:i:sA', User::local_time(Auth::user()->timezone, strtotime($main->created_at)))}}
    @endif
    by <a href="{{route('user.show', ['id'=>$main->user->id])}}">{{$main->user->username}}</a>
    @if ($main->status==2)
        - <span class='pending'>(Pending Approval)</span>
    @elseif ($main->status==0)
        - <span class='denied'>(Denied)</span>
    @elseif ($main->status==3)
        - Inactive(requires proof)
    @endif
    @if (Auth::user())
    <div id='follow_menu' class='right'>
        <form method="POST" action="{{route('follow.update', ['id'=>$main->id])}}">
            @foreach ($errors->all() as $error)
                {{$error}} 
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
              class='active'
              @endif
            >
            Not Following</label>
            <input type='radio' id='follow' name='following' value="1"
              @if ($following)
                checked
              @endif
            >
            <label for='follow' 
              @if ($following)
              class='active'
              @endif
            >
            Following</label>
            <input type='submit' />
        </form>
    </div>
    @endif
</div>
