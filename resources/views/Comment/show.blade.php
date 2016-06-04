<?php
  use App\User;
?>
<div class='comment'>
    <div class='padding-bottom'>
        {{$comment->comment}}
    </div>
    <div>
        <a href="{{route('user.show', ['id'=>$comment->user->id])}}">{{$comment->user->name}}</a>
        -
        @if (Auth::guest())
        {{date('D m/d/y h:i:s', strtotime($comment->created_at))}}
        @elseif (Auth::user())
        {{date('D m/d/y h:i:s', User::local_time(Auth::user()->timezone, strtotime($comment->created_at)))}}
        @endif
    </div>
</div>
