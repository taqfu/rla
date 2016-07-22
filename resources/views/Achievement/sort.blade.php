<?php
$route_name = 'achievement.index';
if (substr(session('achievement_sort'), -4)=="desc"){
    $inverse_order= "asc";
    $inverse_arrow = "&darr;";
    $arrow="&uarr;";
} else if(substr(session('achievement_sort'), -4)==" asc") {
    $inverse_order= "desc";
    $inverse_arrow = "&uarr;";
    $arrow="&darr;";
} else {
    $inverse_order = "asc";
    $inverse_arrow = "&darr;";
    $arrow="&uarr;";
}
?>
<form method="GET" action="{{route('achievement.index')}}" class='margin-bottom text-center'>
    <h4>
        Sort By
    </h4>
    <div class='container-flexible'>
        @if (substr(session('achievement_sort'), 0, 6)=="points")
        <button name='sort' type='submit' value="points {{$inverse_order}}" class='btn-link'>
            <strong>
            By Points {{$inverse_arrow}} 
            </strong>
        </button>
        <button name='sort' type='submit' value='name asc' class='btn-link'>
            By Name
        </button>
        <button name='sort' type='submit' value='date asc' class='btn-link'>
            By Date
        </button>
        @elseif (substr(session('achievement_sort'), 0, 4)=="name")
        <button name='sort' type='submit' value="points asc" class='btn-link'>
            By Points
        </button>
        <button name='sort' type='submit' value="name {{$inverse_order}}" class='btn-link'>
            <strong>
                By Name {{$arrow}}
            </strong>
        </button>
        <button name='sort' type='submit' value="date asc" class='btn-link'>
            By Date 
        </button>
        @elseif (substr(session('achievement_sort'), 0, 4)=="date")
        <button name='sort' type='submit' value="points asc" class='btn-link'>
            By Points
        </button>
        <button name='sort' type='submit' value="name asc" class='btn-link'>
            By Name
        </button>
        <button name='sort' type='submit' value="date {{$inverse_order}}" class='btn-link'>
            <strong>
                By Date {{$inverse_arrow}}
            </strong>
        </button>
        @else
        <button name='sort' type='submit' value="points {{$inverse_order}}" class='btn-link'>
            <strong>
                By Points {{$inverse_arrow}}
            </strong>
        </button>
        <button name='sort' type='submit' value="name asc" class='btn-link'>
            By Name
        </button>
        <button name='sort' type='submit' value="date asc" class='btn-link'>
            By Date
        </button>
        @endif
    </div>
</form>
