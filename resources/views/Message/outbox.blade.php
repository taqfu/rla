
@extends('layouts.app')
@section('content')
@include ('User.menu', ['active'=>'outbox'])
<h1>Outbox</h1>

@forelse ($messages as $message)
    @include ('Message.show', ['type'=>'out', 'message'=>$message])
@empty
    You have not sent any messages.
@endforelse
@endsection
