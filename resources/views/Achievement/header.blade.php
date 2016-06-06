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
    @endif
</div>
