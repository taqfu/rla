<nav class='menu'>
    @if ($active=='profile')
        <strong>{{Auth::user()->username}}</strong>
    @else
        <a href="{{route('user.show', ['id'=>Auth::user()->id])}}">{{Auth::user()->username}}</a>
    @endif
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
</nav>
