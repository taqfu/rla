<div style='margin-left:32px;background-color:lightgrey;width:800px;padding:4px;padding-bottom:2px;border:1px solid black;margin-top:16px;'>
    <div style='padding-bottom:4px;'>
        {{$comment->comment}}
    </div>
    <div style=''>
        <a href="route('user.show', ['id'=>$comment->user->id])}}">{{$comment->user->name}}</a>
        - {{date('D m/d/y h:i:s', strtotime($comment->created_at))}}
    </div> 
</div>
