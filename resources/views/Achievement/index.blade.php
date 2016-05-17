@extends('layouts.app')
@section('content')
@if (Auth::user())
    @include ('Achievement.create') 
@endif
<div style='clear:both;'>
@foreach ($achievements as $achievement)
    <div>
        <a href="{{route('achievement.show', ['id'=> $achievement->id])}}">{{ $achievement->name }}</a>
        @if ($achievement->status==2)
        <span style='font-style:italic;'>
            (Pending Approval)
        </span>
        @endif
    </div>
@endforeach
</div>
@endsection
