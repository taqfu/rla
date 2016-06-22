<?php
  use App\User;
 ?>

<div class='row'>
    <div class='col-xs-1'></div>
    <div class='panel col-xs-10 center-block
    @if (!$message->read && $type=='in')
        panel-primary
    @else 
        panel-default
    @endif
    '>
        <div class='panel-heading'>
            @if ($type=='in')
            From:
            <a href="{{route('user.show', ['id'=>$message->sender->id])}}"
              @if (!$message->read)
              class='unread-user-link'
              @endif
              >
                {{$message->sender->username}}
            </a>
            @elseif ($type=='out')
            To:
            <a href="{{route('user.show', ['id'=>$message->receiver->id])}}">
                {{$message->receiver->username}}
            </a>
            @endif
            Sent:
            @if (Auth::guest())
            {{date('m/d/y h:i:sA e', strtotime($message->created_at))}}
            @elseif (Auth::user())
            {{date('m/d/y h:i:sA', User::local_time(Auth::user()->timezone, strtotime($message->created_at)))}}
            @endif
        </div>
        <div class='panel-body'>
            {{$message->message}}
        </div>
    @if ($type=='in')
        <div class='panel-footer'>
        <a href="{{route('new_message', ['id'=>$message->sender->id])}}">Reply</a>
        <form method="POST" action="{{route('message.update',['id'=>$message->id])}}" class='inline'>
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type='hidden' name='all_read' value='false' />
        @if ($message->read)
            <input type='hidden' name='read' value='false' />
            <input type='submit' value='Mark as unread' class='change-read-status btn-link'>
        @else
            <input type='hidden' name='read' value='true' />
            <input type='submit' value='Mark as read' class='change-read-status btn-link'>
        @endif
        </form>
        </div>
    @endif
    
    
    </div>
    
    <div class='col-xs-1'></div>
</div>
