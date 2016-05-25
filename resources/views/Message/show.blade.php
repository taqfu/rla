<div class='message_container
@if (!$message->read) 
    unread
@endif
'>
    <div>
        @if ($type=='in')
            From:<a href="{{route('user.show', ['id'=>$message->sender->id])}}">{{$message->sender->name}}</a>
        @elseif ($type=='out')
            To:<a href="{{route('user.show', ['id'=>$message->receiver->id])}}">{{$message->receiver->name}}</a>
        @endif
        Sent: {{date('m/d/y g:i:s', strtotime($message->created_at))}}
    </div>
        <div style='margin:8px;margin-bottom:4px;margin-top:4px;'>
        {{$message->message}}
        </div>
@if ($type=='in')
    <a href="{{route('new_message', ['id'=>$message->sender->id])}}">Reply</a>
    <form method="POST" action="{{route('message.update',['id'=>$message->id])}}" style='display:inline;'>
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type='hidden' name='all_read' value='false' />
@if ($message->read)
    <input type='hidden' name='read' value='false' />
    <input type='submit' value='Mark as unread' class='text_button' style='color:blue;'>
@else
    <input type='hidden' name='read' value='true' />
    <input type='submit' value='Mark as read' class='text_button' style='color:blue;'>
@endif
    </form>
    </div>
@endif


</div>
