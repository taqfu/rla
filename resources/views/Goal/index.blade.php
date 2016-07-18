<?php
  use App\Achievement;
  use App\Follow;
  use App\User;
?>
@extends('layouts.app')
@section('title')
    - Your Bucket List
@endsection
@section ('head')
     <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@if (count($goals)>0)
<ul>
@endif
@forelse($goals as $goal)
    <div class='margin-left'>
        @include ('Goal.destroy', ['goal'=>$goal, "extra"=>false])
        {{$goal->rank}})
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
@if (count($goals)>0)
</ul>
@endif
@endsection
