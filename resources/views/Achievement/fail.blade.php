@extends('layouts.app')

@section('content')
<div class='margin-left'>
    Unfortunately, this achievement does not exist. Please

    @if (Auth::user())
    <a href="{{route('new_message', ['username'=>'taqfu'])}}">message here</a>
    @else if (Auth::guest())
    <a href="mailto:taqfu@doitproveit.com">message here</a>
    @endif
    if you'd like to talk to someone about this.
</div>
@endsection
