
@extends('layouts.app')
@section('title')
 - Feedback
@endsection
@section('content')
<div class='text-center'>
    <p>
           Hey, so it's me, <a href="{{route('user.show', ['username'=>'taqfu'])}}">taqfu</a>. Let me know if there are any issues or if you think something could be better. Message me
        @if (Auth::user())
           <a href="{{route('new_message', ['username'=>'taqfu'])}}">here</a>  or
        @endif
        <a href="mailto:taqfu@doitproveit.com">here.</a>
    </p>
    <p>
        You can also comment on Reddit at <a href='https://www.reddit.com/r/doitproveit/'>/r/doitproveit</a>, tweet us on our <a href="https://twitter.com/doit_proveit">Twitter</a>, like us on our <a href="http://www.facebook.com/Do-It-Prove-It-265125053841485">Facebook</a> or do whatever it is that people do on our <a href="https://plus.google.com/u/0/b/111000706342354560427/111000706342354560427/about">Google Plus</a>.
    </p>
</div>

@endsection
