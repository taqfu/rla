@extends('layouts.app')
@section('content')
@include ('User.menu', ['active'=>'votes'])
<h1>
    Voting History
</h1>
<table>
@foreach($votes as $vote)
<div>
    <tr><td>
        {{date('M d, Y h:i', strtotime($vote->created_at))}}
    </td><td>
        @include ('Vote.show', ['voted_for'=>$vote->vote_for])
    </td><td>
        <a href="{{$vote->proof->url}}">{{$vote->proof->url}}</a>
    </td><td>
        <a href="{{route('user.show', ['id'=>$vote->proof->user_id])}}">{{$vote->proof->user->name}}</a>
    </td><td>
        <a href="{{route('achievement.show', ['id'=>$vote->proof->achievement->id])}}">{{$vote->proof->achievement->name}}</a> 
    </td><td>
        <a href="{{route('user.show', ['id'=>$vote->proof->achievement->user_id])}}">{{$vote->proof->achievement->user->name}}</a>
    </td></tr>
</div>
@endforeach
</table>
@endsection
