<nav id='user_profile_menu'>
    <span>
    @if ($active=='profile')
        <strong>{{$profile->username}}</strong>
    @else
        <a href="{{route('user.show', ['id'=>$profile->id])}}">{{$profile->username}}</a>
    @endif
    </span>
    <span>
    @if ($active=='comments')
        <strong>Comments</strong>
    @else
        <a href="{{route('user.comments', ['id'=>$profile->id])}}">Comments</a>
    @endif
    </span>
@if(Auth::user() && $profile->id == Auth::user()->id)
    <span>
    @if ($active=='votes')
        <strong>Votes</strong>
    @else
        <a href="{{route('vote.index')}}">Votes</a>
    @endif
    </span>
    <span>
    @if ($active=='inbox')
        <strong>Inbox</strong>
    @else
        <a href="{{route('inbox')}}">Inbox</a>
    @endif
    </span>
    <span>
    @if ($active=='outbox')
        <strong>Outbox</strong>
    @else
        <a href="{{route('outbox')}}">Outbox</a>
    @endif
    </span>
    <span>
    @if ($active=='settings')
        <strong>Settings</strong>
    @else
        <a href="{{route('settings')}}">Settings</a>
    @endif
    </span>
@endif
</nav>
