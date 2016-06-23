@extends ('layouts.app')

@section('content')
<div class='panel panel-default'>
    <div class='panel-body text-center'>
        @include ('Timeline.description')
    </div>
    <div>
    @include ('Timeline.footer')
    </div>
</div>
@if (Auth::user())
<div class='margin-left'>
    <a href="{{route('home')}}">Back To Timeline</a>
</div>
@endif
@endsection
