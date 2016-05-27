@extends('layouts.app')
@section('content')
@include ('User.menu', ['active'=>'votes'])
<table>
    <tr>
        <th>
            Timestamp
        </th>    
        <th>
            Vote
        </th>
        <th>
            Proof
        </th>
        <th>
            Proof Submitter
        </th>
        <th>
            Achievement
        </th>
        <th>
            Achievement Creator
        </th>
    </tr>
@foreach($votes as $vote)
    <tr><td>
        <div style='width:175px;'>
        {{date('M d, Y', strtotime($vote->created_at))}}
        </div>
        <div>
        {{date('g:i', strtotime($vote->created_at))}}
        </div>
    </td><td style="color:{{$vote->vote_for ? 'green' : 'red'}};">
        {{ $vote->vote_for ? "for" : "against" }}
    </td><td>
        <a href="{{route('proof.show', ['id'=>$vote->proof->id])}}">Proof #{{$vote->proof->id}}</a> 
        <a href="{{$vote->proof->url}}">(submission)</a>
    </td><td>
        <a href="{{route('user.show', ['id'=>$vote->proof->user_id])}}">{{$vote->proof->user->name}}</a>
    </td><td>
        <a href="{{route('achievement.show', ['id'=>$vote->proof->achievement->id])}}">{{$vote->proof->achievement->name}}</a> 
    </td><td>
        <a href="{{route('user.show', ['id'=>$vote->proof->achievement->user_id])}}">{{$vote->proof->achievement->user->name}}</a>
    </td></tr>
@endforeach
</table>
@endsection
