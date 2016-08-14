@extends ('layouts.app')

@section('content')
<div class='panel panel-default'>
    <div class='panel-body text-center'>
        @include ('Timeline.description')
    </div>
    <div>
    @include ('share', ['url'=>route('timeline.show', ['id'=>$timeline_item->id])])
    </div>
</div>
@endsection
