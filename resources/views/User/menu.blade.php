<nav>
    @if ($active=='profile')
        <span style='font-weight:bold;'>Profile</span>
    @else
        <a href="{{route('user.show', ['id'=>Auth::user()->id])}}">Profile</a>
    @endif
    @if ($active=='votes')
        <span style='font-weight:bold;'>Vote History</span>
    @else
        <a href="{{route('vote.index')}}">Vote History</a>
    @endif
    @if ($active=='inbox')
        <span style='font-weight:bold;'>Inbox</span>
    @else
        <a href="{{route('inbox')}}">Inbox</a>
    @endif
    @if ($active=='outbox')
        <span style='font-weight:bold;'>Outbox</span>
    @else
        <a href="{{route('outbox')}}">Outbox</a>
    @endif
    @if ($active=='settings')
        <span style='font-weight:bold;'>Settings</span>
    @else
        <a href="{{route('settings')}}">Settins</a>
    @endif
</nav>
