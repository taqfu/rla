<?php
    use App\Comment;
?>
<ul class='nav nav-tabs'>
    <li class='
      @if ($active_item=='info')
      active
      @endif
      '>
        <a href="{{route('achievement.show', ['url'=>$url])}}">Info</a>
    </li>
    <li class='
      @if ($active_item=='proofs')
      active
      @endif
      '>
        <a href="{{route('achievement.showProofs', ['url'=>$url])}}">Proofs ({{count($main->proofs)}})</a>

    </li>
    <li class='
      @if ($active_item=='claims')
      active
      @endif
      '>
        <a href="{{route('achievement.showClaims', ['url'=>$url])}}">Claims ({{count($main->claims)}})</a>
    </li>
    <li class='
      @if ($active_item=='discussion')
      active
      @endif
      '>
          <a href="{{route('achievement.discussion', ['url'=>$url])}}">Discussion ({{count($main->comments)}})</a>
    </li>

</ul>
