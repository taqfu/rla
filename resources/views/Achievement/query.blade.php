@foreach($achievements as $achievement)
    @if (!isset($first_achievement))
    <?php $first_achievement = $achievement; ?>
        <div class='panel panel-default'><strong>
            Pressing enter will
            @if(count($achievements)==1)
                redirect you to achievement "{{$first_achievement->name}}"
            @else
                create the achievement "{{$searchQuery}}"
            @endif
        </strong></div>
    @endif


    <div class='panel panel-default'>
        <a href="{{route('achievement.show', ['url'=>$achievement->url])}}"><div>{{$achievement->name}} ({{$achievement->score}})</div></a>
    </div>
@endforeach
@if (count($achievements)==0)
    <div class='panel panel-default' ><strong>
        Pressing enter will create the achievement "{{$searchQuery}}"
    </strong></div>
@endif

@if ($achievementDoesNotExist)
<form  method="POST" action="{{route('achievement.store')}}">
    {{csrf_field()}}
    <input type='hidden' name='name' value='{{$searchQuery}}' />
    <input type='submit' value="Create Achievement &quot;{{$searchQuery}}&quot;" class='btn-block '/>
</form>
@endif
@if (count($achievements)==1)
    <input type='hidden' id='default_result' value="{{route('achievement.show', ['url'=>$achievement->url])}}" />
@else
    <form id="default_result" method="POST" action="{{route('achievement.store')}}">
        {{csrf_field()}}
        <input type='hidden' name='name' value='{{$searchQuery}}' />
    </form>
@endif
