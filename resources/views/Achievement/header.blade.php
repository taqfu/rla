<h1 class='
    @if ($main->status==0)
        denied
    @elseif ($main->status==1)
        approved
    @elseif ($main->status==2)
        pending
    @endif       
'>
    {{$main->name }} 
</h1>
<div id='header_info'>
    Submitted: {{ date('m/d/y h:iA', strtotime($main->created_at))}} by <a href="{{route('user.show', ['id'=>$main->user->id])}}">{{$main->user->username}}</a>
    @if ($main->status==2)
        - <span class='pending'>(Pending Approval)</span>
    @elseif ($main->status==0)
        - <span class='denied'>(Denied)</span>
    @endif
</div>
