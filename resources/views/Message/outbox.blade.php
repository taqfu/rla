
@extends('layouts.app')
@section('title')
 - Outbox
@endsection
@section('content')
@include ('User.menu', ['active'=>'outbox'])

@forelse ($messages as $message)
    @include ('Message.show', ['type'=>'out', 'message'=>$message])
@empty
<div class='well'>
    You have not sent any messages.
</div>
@endforelse
@endsection
