<div class='center margin-top2'>
    Sorted by: 
    @if (substr($sort, 0, 6)=="points")
    (Points
    @elseif (substr($sort, 0, 4)=="name")
    (Name
    @elseif (substr($sort, 0, 4)=="date")
    (Date
    @else
    (Points
    @endif
    @if (substr($sort, -4)=="desc")
        @if (substr($sort, 0, 6)=="points")
        &uarr;)
        @else
        &darr;)
        @endif
    @elseif(substr($sort, -4)==" asc")
        &uarr;)
    @else
        &darr;)
    @endif
    Sort By:

    @if (substr($sort, 0, 6)=="points")
        @if (substr($sort, -4)=="desc")
        <a href="{{route('achievement.index', ['sort'=>'points asc'])}}">By Points &uarr;</a>
        @elseif(substr($sort, -4)==" asc")
        <a href="{{route('achievement.index', ['sort'=>'points desc'])}}">By Points &darr;</a>
        @endif
    <a href="{{route('achievement.index', ['sort'=>'name asc'])}}">By Name &uarr;</a>
    <a href="{{route('achievement.index', ['sort'=>'date asc'])}}">By Date &uarr;<a/> 
    @elseif (substr($sort, 0, 4)=="name")
    <a href="{{route('achievement.index', ['sort'=>'points desc'])}}">By Points &darr;</a>
        @if (substr($sort, -4)=="desc")
        <a href="{{route('achievement.index', ['sort'=>'name asc'])}}">By Name &uarr;</a>
        @elseif(substr($sort, -4)==" asc")
        <a href="{{route('achievement.index', ['sort'=>'name desc'])}}">By Name &darr;</a>
        @endif
    <a href="{{route('achievement.index', ['sort'=>'date asc'])}}">By Date &uarr;<a/> 
    @elseif (substr($sort, 0, 4)=="date")
    <a href="{{route('achievement.index', ['sort'=>'name asc'])}}">By Name &uarr;</a>
    <a href="{{route('achievement.index', ['sort'=>'points desc'])}}">By Points &darr;</a>
        @if (substr($sort, -4)=="desc")
        <a href="{{route('achievement.index', ['sort'=>'date asc'])}}">By Date &uarr;<a/> 
        @elseif(substr($sort, -4)==" asc")
        <a href="{{route('achievement.index', ['sort'=>'date desc'])}}">By Date &darr;<a/> 
        @endif
    @else
        <a href="{{route('achievement.index', ['sort'=>'points asc'])}}">By Points &uarr;</a>
        <a href="{{route('achievement.index', ['sort'=>'name asc'])}}">By Name &uarr;</a>
        <a href="{{route('achievement.index', ['sort'=>'date asc'])}}">By Date &uarr;<a/> 
    @endif
</div>
