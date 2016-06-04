<?php
use App\User;
 ?>
@extends('layouts.app')
@section('title')
 - Vote History
@endsection
@section('content')
@include ('User.menu', ['active'=>'votes'])
@if (count($votes)>0)
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
            @if (Auth::guest())
	          {{date('M d, Y', strtotime($vote->created_at))}}
            @elseif (Auth::user())
            {{date('M d, Y', User::local_time(Auth::user()->timezone, strtotime($vote->created_at)))}}
            @endif
	        </div>
	        <div>
          @if (Auth::guest())
          {{date('g:i', strtotime($vote->created_at))}}
          @elseif (Auth::user())
          {{date('g:i', User::local_time(Auth::user()->timezone, strtotime($vote->created_at)))}}
          @endif
	        </div>
	    </td><td style="color:{{$vote->vote_for ? 'green' : 'red'}};">
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
You have not voted yet.
@endif
@endsection
