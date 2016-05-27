
@extends('layouts.app')
@section('content')
@include ('User.menu', ['active'=>'outbox'])

@forelse ($messages as $message)
    @include ('Message.show', ['type'=>'out', 'message'=>$message])
@empty
    You have not sent any messages.
@endforelse
@endsection
