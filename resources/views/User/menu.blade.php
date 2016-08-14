<ul id='user-profile-menu' class='nav nav-tabs'>
    <li class="
      @if ($active=='completed')
      active
      @endif
      ">
        <a href="{{route('user.achievements.completed', ['username'=>$profile->username])}}">Completed</a>
    </li>
    <li class="
      @if ($active=='claimed')
      active
      @endif
      ">
        <a href="{{route('user.achievements.claimed', ['username'=>$profile->username])}}">Claimed</a>
    </li>
    <li class="
      @if ($active=='created')
      active
      @endif
      ">
        <a href="{{route('user.achievements.created', ['username'=>$profile->username])}}">Created</a>
    </li>
    <li class="
      @if ($active=='goals')
      active
      @endif
      ">
        <a href="{{route('user.achievements.goals', ['username'=>$profile->username])}}">Bucket List</a>
    </li>
    <li class="
      @if ($active=='subscriptions')
      active
      @endif
      ">
        <a href="{{route('user.achievements.subscriptions', ['username'=>$profile->username])}}">Subscriptions</a>
    </li>
    <li class="
      @if ($active=='comments')
      active
      @endif
      ">
        <a href="{{route('user.comments', ['username'=>$profile->username])}}">Comments</a>
    </li>
@if(Auth::user() && $profile->id == Auth::user()->id)
    <li class="
      @if ($active=='votes')
      active
      @endif
      ">
        <a href="{{route('vote.index')}}">Votes</a>
    </li>
    <li class="
      @if ($active=='inbox')
      active
      @endif
      ">
        <a href="{{route('inbox')}}">Inbox</a>
    </li>
    <li class="
      @if ($active=='outbox')
      active
      @endif
      ">
        <a href="{{route('outbox')}}">Outbox</a>
    </li>
    <li class="
      @if ($active=='settings')
      active
      @endif
      ">
        <a href="{{route('settings')}}">Settings</a>
    </li>
@endif
</ul>
