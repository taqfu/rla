
@extends('layouts.app')

@section('title')
 -  @if (strlen($main->name)>61)
    {{substr($main->name, 0, 61)}}...
    @else
    {{$main->name}}
    @endif
@endsection

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta property="og:title" content="{{$main->name}}" />
<meta property="og:description" content="Do It! Prove It! achievement profile for &quot;{{$main->name}}&quot; - Created by {{$main->user->username}} "/>
@endsection
@section('content')
@if (Auth::user())
<!--
    @include ('Follow.create')
-->
    @if ($user_goal==null)
    @include('Goal.create', ['id'=>$main->id])
    @else
    @include ('Goal.destroy', ['goal'=>$user_goal, 'extra'=>true])
    @endif
@endif
<h1 class='text-center'>
    {{$main->name }}
</h1>
@include ('Achievement.menu', ['id'=>$main->id, 'url'=>$main->url, 'active_item'=>'info'])
@include ('Achievement.header')


@foreach ($timelines as $timeline)
    @if ($timeline->proof_id>0)
        @include('Achievement.profile.proof', ['proof'=>$timeline->proof])
    @elseif ($timeline->claim_id>0)
        @include ('Achievement.profile.claim', ['claim'=>$timeline->claim])
    @elseif ($timeline->goal_id>0)
        @include ('Achievement.profile.goal', ['goal'=>$timeline->goal])
    @endif
@endforeach
@endsection
