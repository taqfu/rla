
@forelse($goals as $goal)
<div id='bucket-list-item{{$goal->rank}}' class='bucket-list-item panel panel-default' 
  draggable='true'>
    @include ('Goal.destroy', ['goal'=>$goal, "extra"=>false])
    {{$goal->rank}}
    <a href="{{route('achievement.show', ['url'=>$goal->achievement->url])}}">
        {{$goal->achievement->name}}
    </a>
    (<a href="{{route('user.show', ['username'=>$goal->user->username])}}">
        {{$goal->user->username}}
    </a>)
</div>
@empty
<div class='margin-left lead'>
    You do not have any items in your bucket list. Add some today!
</div>
@endforelse
