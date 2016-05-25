<nav>
    @if ($active_item=='info')
        <span style='font-weight:bold;'>Information</span>
        <a href="{{route('discussion', ['id'=>$id])}}">Discussion</a>
    @elseif ($active_item=='discussion')
        <a href="{{route('achievement.show', ['id'=>$id])}}">Information</a>
        <span style='font-weight:bold;'>Discussion</span>
    @endif
        
</nav>
