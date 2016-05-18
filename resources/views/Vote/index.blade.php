@extends('layouts.app')
@section('content')
<table>
@foreach($votes as $vote)
<div>
    <tr><td>
        @include ('Vote.show', ['voted_for'=>$vote->vote_for])
    </td><td>
        <a href="{{route('achievement.show', ['id'=>$vote->proof->achievement->id])}}">{{$vote->proof->achievement->name}}</a> 
    </td><td>
        <a href="{{$vote->proof->url}}">{{$vote->proof->url}}</a>
    </td><td>
        {{$vote->proof->user->name}} 
    </td><td>
        {{date('M d, Y h:i', strtotime($vote->created_at))}}
    </td></tr>
</div>
@endforeach
</table>
@endsection
