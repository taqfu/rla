@extends('layouts.app')
@section('content')
<h1 class='text-center'>
    {{$main->name }}
</h1>
@include ('Achievement.menu', ['id'=>$main->id, 'active_item'=>'discussion'])
@include ('Achievement.header')
@if (Auth::user())
    @include ('Comment.create', ['table'=>'achievement', 'table_id'=>$main->id, 'show'=>true])
@endif
<div id='discussion-container' class='margin-left'>
@foreach ($main->comments as $comment)
    @include ('Comment.show', ['comment'=>$comment])
@endforeach
</div>
@endsection
