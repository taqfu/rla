<?php
    use App\Comment;
?>
<nav class='menu'>
    @if ($active_item=='info')
        <strong>Proofs</strong>
        <a href="{{route('discussion', ['id'=>$id])}}">Discussion ({{count(Comment::where('achievement_id', $id)->get())}})</a>
    @elseif ($active_item=='discussion')
        <a href="{{route('achievement.show', ['id'=>$id])}}">Proofs</a>
        <strong>Discussion</strong>
    @endif
        
</nav>
