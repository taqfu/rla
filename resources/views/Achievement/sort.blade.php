<?php 
    if ($page_type=='listing'){
        $route_name = 'achievement.index';
    } else if ($page_type='inventory'){
        $route_name = 'inventory';
    }
?>
<div class='center margin-top2'>
    Sort By:

    @if (substr($sort, 0, 6)=="points")
    <strong>
        @if (substr($sort, -4)=="desc")
        <a href="{{route($route_name, ['sort'=>'points asc'])}}">By Points &darr;</a>
        @elseif(substr($sort, -4)==" asc")
        <a href="{{route($route_name, ['sort'=>'points desc'])}}">By Points &uarr;</a>
        @endif
    </strong>
    <a href="{{route($route_name, ['sort'=>'name asc'])}}">By Name &darr;</a>
    <a href="{{route($route_name, ['sort'=>'date asc'])}}">By Date &darr;<a/> 
    @elseif (substr($sort, 0, 4)=="name")
    <a href="{{route($route_name, ['sort'=>'points desc'])}}">By Points &darr;</a>
    <strong>
        @if (substr($sort, -4)=="desc")
        <a href="{{route($route_name, ['sort'=>'name asc'])}}">By Name &uarr;</a>
        @elseif(substr($sort, -4)==" asc")
        <a href="{{route($route_name, ['sort'=>'name desc'])}}">By Name &darr;</a>
        @endif
    </strong>
    <a href="{{route($route_name, ['sort'=>'date asc'])}}">By Date &darr;<a/> 
    @elseif (substr($sort, 0, 4)=="date")
    <a href="{{route($route_name, ['sort'=>'points desc'])}}">By Points &darr;</a>
    <a href="{{route($route_name, ['sort'=>'name asc'])}}">By Name &darr;</a>
    <strong>
        @if (substr($sort, -4)=="desc")
        <a href="{{route($route_name, ['sort'=>'date asc'])}}">By Date &uarr;<a/> 
        @elseif(substr($sort, -4)==" asc")
        <a href="{{route($route_name, ['sort'=>'date desc'])}}">By Date &darr;<a/> 
        @endif
    </strong>
    @else
        <strong>
            <a href="{{route($route_name, ['sort'=>'points asc'])}}">By Points &darr;</a>
        </strong>
        <a href="{{route($route_name, ['sort'=>'name asc'])}}">By Name &darr;</a>
        <a href="{{route($route_name, ['sort'=>'date asc'])}}">By Date &darr;<a/> 
    @endif
</div>
