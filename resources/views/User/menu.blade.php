<ul id='user-profile-menu' class='nav nav-tabs'>
    <li class="
      @if ($active=='profile')
      active
      @endif
      ">
        <a href="{{route('user.show', ['id'=>$profile->id])}}">{{$profile->username}}</a>
    </li>
    <li class="
      @if ($active=='comments')
      active
      @endif
      ">
        <a href="{{route('user.comments', ['id'=>$profile->id])}}">Comments</a>
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
