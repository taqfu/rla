
@extends('layouts.app')
@section('title')
 - Inbox
@endsection
@section('content')
@include ('User.menu', ['active'=>'inbox'])
@forelse ($messages as $message)
    @include ('Message.show', ['type'=>'in', 'message'=>$message])
@empty
    <div class='well'>
    You have not received any messages.
    </div>
@endforelse
@endsection
