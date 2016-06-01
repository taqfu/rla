<?php
    use App\Comment;
?>
<nav class='menu'>
    @if ($active_item=='info')
        <strong>Info</strong>
        <a href="{{route('discussion', ['id'=>$id])}}">Discussion ({{count(Comment::where('achievement_id', $id)->get())}})</a>
    @elseif ($active_item=='discussion')
        <a href="{{route('achievement.show', ['id'=>$id])}}">Info</a>
        <strong>Discussion</strong>
    @endif
        
</nav>
