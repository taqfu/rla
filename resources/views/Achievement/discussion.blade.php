@extends('layouts.app')
@section('content')
@include ('Achievement.menu', ['id'=>$main->id, 'active_item'=>'discussion'])
@include ('Achievement.header')
@if (Auth::user())
    @include ('Comment.create', ['table'=>'achievement', 'table_id'=>$main->id, 'show'=>true])
@endif
@foreach ($main->comments as $comment)
    @include ('Comment.show', ['comment'=>$comment])
@endforeach
@endsection
