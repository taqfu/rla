
@extends('layouts.app')
@section('title')
 - Inbox
@endsection
@section('content')
@include ('User.menu', ['active'=>'inbox'])
<!--
@if (count($messages)>0)
<form method="POST" action="">
    {{csrf_field()}}
    {{ method_field('PUT') }}
    <input type='hidden' name='all_read' value='true' />
    <input type='submit' value='Mark All As Unread' class='text_button' />
</form>
@endif
-->
@forelse ($messages as $message)
    @include ('Message.show', ['type'=>'in', 'message'=>$message])
@empty
    You have not received any messages.
@endforelse
@endsection
