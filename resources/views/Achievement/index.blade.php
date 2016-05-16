@extends('layouts.app')
@section('content')
@if (Auth::user())
    @include ('Achievement.create') 
@endif
<div style='clear:both;'>
@foreach ($achievements as $achievement)
    <div>
        {{ $achievement->name }}
        @if ($achievement->status==2)
        <span style='color:red;'>
            (Pending Approval)
        </span>
        @endif
    </div>
@endforeach
</div>
@endsection
