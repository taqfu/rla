<div class='timeline margin-left'>
    <span title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</span> - 
    @if ($timeline_item->user_id==Auth::user()->id)
    You
    @else
    <a href="{{route('user.show', ['id'=>$timeline_item->user_id])}}">{{$timeline_item->user->username}}</a>
    @endif
     posted the following comment "<i>{{$timeline_item->comment->comment}}</i>"
    @if ($timeline_item->comment->achievement_id>0)
     on <a href="{{route('discussion', ['id'=>$timeline_item->comment->achievement_id])}}">your achievement discussion page</a>
     for <a href="{{route('achievement.show', ['id'=>$timeline_item->comment->achievement_id])}}">"{{$timeline_item->comment->achievement->name}}"</a>.
    @elseif ($timeline_item->comment->proof_id>0)
        @if ($timeline_item->event=="new comment")
             on <a href="{{route('proof.show', ['id'=>$timeline_item->comment->proof_id])}}">your proof</a> for 
            <a href="{{route('achievement.show', ['id'=>$timeline_item->comment->proof_id])}}#proof{{$timeline_item->comment->proof->achievement_id}}">"{{$timeline_item->comment->proof->achievement->name}}"</a>.
        @elseif ($timeline_item->event=="new proof vote comment")
            on a vote for <a href="{{route('proof.show', ['id'=>$timeline_item->comment->vote->proof_id])}}">your proof</a> for <a href="{{route('achievement.show', ['id'=>$timeline_item->comment->vote->achievement_id])}}">"{{$timeline_item->comment->vote->achievement->name}}"</a>.
        @endif
    @elseif ($timeline_item->comment->vote_id>0)
        on
        @if ($timeline_item->comment->vote->user_id==Auth::user()->id)
            your 
        @else
            @if (substr($string, -1, 1)=="s")
                <a href="{{route('user.show', ['id'=>$timeline_item->comment->vote->user_id])}}">{{$timeline_item->comment->vote->user->username}}'</a>
            @else
                <a href="{{route('user.show', ['id'=>$timeline_item->comment->vote->user_id])}}">{{$timeline_item->comment->vote->user->username}}'s</a>
            @endif
        @endif
        vote for     
        @if ($timeline_item->comment->vote->user_id==Auth::user()->id)
          <a href="{{route('proof.show', ['id'=>$timeline_item->comment->vote->proof_id])}}">your proof</a>    
        @else
          the <a href="{{route('proof.show', ['id'=>$timeline_item->comment->vote->proof_id])}}">proof</a>
        @endif
         for 
         <a href="{{route('achievement.show', ['id'=>$timeline_item->comment->vote->achievement_id])}}#proof{{$timeline_item->comment->vote->proof_id}}">"{{$timeline_item->comment->vote->achievement->name}}"</a>.
    
    @endif
</div>
