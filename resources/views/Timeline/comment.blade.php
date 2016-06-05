<div class='margin-left'>
<a href="{{route('user.show', ['id'=>$timeline_item->user->id])}}">{{$timeline_item->user->username}}</a> posted the following comment "<i>{{$timeline_item->comment->comment}}</i>"
@if ($timeline_item->comment->achievement_id>0)
 on your achievement discussion page for <a href="{{route('discussion', ['id'=>$timeline_item->comment->achievement_id])}}">"{{$timeline_item->comment->achievement->name}}"</a>.
@elseif ($timeline_item->comment->proof_id>0)
 on your proof for 
<a href="{{route('achievement.show', ['id'=>$timeline_item->comment->proof_id])}}#proof{{$timeline_item->comment->proof->achievement_id}}">"{{$timeline_item->comment->proof->achievement->name}}"</a>.
@elseif ($timeline_item->comment->vote_id>0)
    on
    @if ($timeline_item->comment->vote->user_id==Auth::user()->id)
        your 
    @else
        <!--//add appropriate possiveness with s and not s
        -->
    @endif
    vote for <a href="{{route('proof.show', ['id'=>$timeline_item->comment->vote->proof_id])}}">your proof</a> for 
<a href="{{route('achievement.show', ['id'=>$timeline_item->comment->vote->achievement_id])}}#proof{{$timeline_item->comment->vote->proof_id}}">"{{$timeline_item->comment->vote->achievement->name}}"</a>.

@endif
</div>
