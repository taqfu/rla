<?php
use App\User;
 ?>
@extends('layouts.app')
@section('title')
 - Vote History
@endsection
@section('content')
@include ('User.header')
@include ('User.menu', ['active'=>'votes'])
@if (count($votes)>0)
	<table id='user-votes' class='table'>
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
            {{interval($vote->created_at, "now")}} ago
	    </td><td class="{{$vote->vote_for ? 'pass' : 'fail'}}">
	        {{ $vote->vote_for ? "for" : "against" }}
	    </td><td>
	        <a href="{{route('proof.show', ['id'=>$vote->proof->id])}}">Proof #{{$vote->proof->id}}</a>
	        <a href="{{$vote->proof->url}}">(submission)</a>
	    </td><td>
	        <a href="{{route('user.show', ['id'=>$vote->proof->user_id])}}">{{$vote->proof->user->username}}</a>
	    </td><td>
	        <a href="{{route('achievement.show', ['id'=>$vote->proof->achievement->id])}}">{{$vote->proof->achievement->name}}</a>
	    </td><td>
	        <a href="{{route('user.show', ['id'=>$vote->proof->achievement->user_id])}}">{{$vote->proof->achievement->user->username}}</a>
	    </td></tr>
	@endforeach
	</table>
@else
<div class='margin-left'>
    You have not voted yet.
</div>
@endif
@endsection
