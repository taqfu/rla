
@extends('layouts.app')
@section('content')
<div class='center'>
    Hey, so it's me, taqfu. Just let me know what you think could be better. Message me 
@if (Auth::user())
   <a href="{{route('new_message', ['id'=>1])}}">here</a>  or 
@endif
<a href="mailto::taqfu0@gmail.com">here.</a>
</div>
@endsection


