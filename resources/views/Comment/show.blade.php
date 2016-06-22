<?php
  use App\User;
?>
<div class='panel panel-default'>
    <div class='panel-header'>
        <a href="{{route('user.show', ['id'=>$comment->user->id])}}">{{$comment->user->username}}</a>
        -
        @if (Auth::guest())
        {{date('D m/d/y h:i:sA e', strtotime($comment->created_at))}}
        @elseif (Auth::user())
        {{date('D m/d/y h:i:sA', User::local_time(Auth::user()->timezone, strtotime($comment->created_at)))}}
        @endif
    </div>
    <div class='panel-body'>
        {{$comment->comment}}
    </div>
</div>
