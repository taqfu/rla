<nav class='menu'>
    @if ($active=='profile')
        <strong>{{$profile->username}}</strong>
    @else
        <a href="{{route('user.show', ['id'=>$profile->id])}}">{{$profile->username}}</a>
    @endif
    @if ($active=='comments')
        <strong>Comments</strong>
    @else
        <a href="{{route('user.comments', ['id'=>$profile->id])}}">Comments</a>
    @endif
@if(Auth::user() && $profile->id == Auth::user()->id)
    @if ($active=='votes')
        <strong>Votes</strong>
    @else
        <a href="{{route('vote.index')}}">Votes</a>
    @endif
    @if ($active=='inbox')
        <strong>Inbox</strong>
    @else
        <a href="{{route('inbox')}}">Inbox</a>
    @endif
    @if ($active=='outbox')
        <strong>Outbox</strong>
    @else
        <a href="{{route('outbox')}}">Outbox</a>
    @endif
    @if ($active=='settings')
        <strong>Settings</strong>
    @else
        <a href="{{route('settings')}}">Settings</a>
    @endif
@endif
</nav>
