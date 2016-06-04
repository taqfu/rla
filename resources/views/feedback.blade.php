
@extends('layouts.app')
@section('title')
 - Feedback
@endsection
@section('content')
<div class='center'>
<p>
   Hey, so it's me, <a href='http://taqfu.com'>taqfu</a>. Let me if there are any issues or if you think something could be better. Message me 
@if (Auth::user())
   <a href="{{route('new_message', ['id'=>1])}}">here</a>  or 
@endif
<a href="mailto::taqfu@doitproveit.com">here.</a>
</p>
<p>
    You can also comment on our subreddit <a href='https://www.reddit.com/r/doitproveit/'>here</a>.
</p>
</div>

@endsection


