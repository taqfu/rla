<?php
    use App\Comment;
?>
<ul class='nav nav-tabs'>
    <li class='
      @if ($active_item=='info')
      active
      @endif
      '>
        <a href="{{route('achievement.show', ['id'=>$id])}}">Proofs</a>
    </li>
    <li class='
      @if ($active_item=='discussion')
      active
      @endif
      '>
          <a href="{{route('discussion', ['id'=>$id])}}">Discussion ({{count(Comment::where('achievement_id', $id)->get())}})</a>
    </li>
        
</ul>
