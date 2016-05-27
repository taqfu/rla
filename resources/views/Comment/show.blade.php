<div class='comment'>
    <div class='padding-bottom'>
        {{$comment->comment}}
    </div>
    <div>
        <a href="route('user.show', ['id'=>$comment->user->id])}}">{{$comment->user->name}}</a>
        - {{date('D m/d/y h:i:s', strtotime($comment->created_at))}}
    </div> 
</div>
