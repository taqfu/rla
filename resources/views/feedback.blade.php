
@extends('layouts.app')
@section('content')
<div class='center'>
<p>
    Hey, so it's me, <a href='http://taqfu.com'>taqfu</a>. Just let me know what you think could be better or if there are any issues. Message me 
@if (Auth::user())
   <a href="{{route('new_message', ['id'=>1])}}">here</a>  or 
@endif
<a href="mailto::taqfu0@gmail.com">here.</a>
</p>
<p>
    You can also comment on Reddit <a href='https://www.reddit.com/r/doitproveit/'>here</a>.
</p>
</div>

@endsection


