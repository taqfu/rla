<?php
  use App\User;
 ?>
<div class='message_container
@if (!$message->read && $type=='in')
    unread
@endif
'>
    <div>
        @if ($type=='in')
            From:<a href="{{route('user.show', ['id'=>$message->sender->id])}}">{{$message->sender->username}}</a>
        @elseif ($type=='out')
            To:<a href="{{route('user.show', ['id'=>$message->receiver->id])}}">{{$message->receiver->username}}</a>
        @endif
        Sent:
        @if (Auth::guest())
        {{date('m/d/y h:i:sA e', strtotime($message->created_at))}}
        @elseif (Auth::user())
        {{date('m/d/y h:i:sA', User::local_time(Auth::user()->timezone, strtotime($message->created_at)))}}
        @endif
    </div>
        <div class='message'>
        {{$message->message}}
        </div>
@if ($type=='in')
    <a href="{{route('new_message', ['id'=>$message->sender->id])}}">Reply</a>
    <form method="POST" action="{{route('message.update',['id'=>$message->id])}}" class='inline'>
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type='hidden' name='all_read' value='false' />
@if ($message->read)
    <input type='hidden' name='read' value='false' />
    <input type='submit' value='Mark as unread' class='text_button change_read_status'>
@else
    <input type='hidden' name='read' value='true' />
    <input type='submit' value='Mark as read' class='text_button change_read_status'>
@endif
    </form>
    </div>
@endif


</div>
