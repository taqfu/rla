<?php
$route_name = 'achievement.index';
if (substr($sort, -4)=="desc"){
    $inverse_order= "asc";
    $inverse_arrow = "&darr;";
} else if(substr($sort, -4)==" asc") {
    $inverse_order= "desc";
    $inverse_arrow = "&uarr;";
} else {
    $inverse_order = "asc";
    $inverse_arrow = "&darr;";
}
?>
<div class='margin-bottom'>
    <h4>
        Sort By
    </h4>
    <div class='container-flexible'>
        @if (substr($sort, 0, 6)=="points")
        <button name='sort' type='submit' value="points {{$inverse_order}}" class='btn-link'>
            <strong>
            By Points {{$inverse_arrow}} 
            </strong>
        </button>
        <button name='sort' type='submit' value='name asc' class='btn-link'>
            By Name &darr;
        </button>
        <button name='sort' type='submit' value='date asc' class='btn-link'>
            By Date &darr;
        </button>
        @elseif (substr($sort, 0, 4)=="name")
        <button name='sort' type='submit' value="points asc" class='btn-link'>
            By Points &darr;
        </button>
        <button name='sort' type='submit' value="name {{$inverse_order}}" class='btn-link'>
            <strong>
                By Name {{$inverse_arrow}}
            </strong>
        </button>
        <button name='sort' type='submit' value="date asc" class='btn-link'>
            By Date &darr;
        </button>
        @elseif (substr($sort, 0, 4)=="date")
        <button name='sort' type='submit' value="points asc" class='btn-link'>
            By Points &darr;
        </button>
        <button name='sort' type='submit' value="name asc" class='btn-link'>
            By Name &darr;
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
            By Name &darr;
        </button>
        <button name='sort' type='submit' value="date asc" class='btn-link'>
            By Date &darr;
        </button>
        @endif
    </div>
</div>
