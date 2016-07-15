@extends('layouts.app')

@section('content')
<div class='margin-left'>
    Unfortunately, this achievement has been deleted. Hopefully, this wasn't censorship! (We really don't want to engage in that kind of behavior.) Please

    @if (Auth::user())
    <a href="{{route('new_message', ['username'=>'taqfu'])}}">message me</a>
    @else if (Auth::guest())
    <a href="mailto:taqfu@doitproveit.com">message me</a>
    @endif

    if you'd like to talk to someone about this.
</div>
@endsection
