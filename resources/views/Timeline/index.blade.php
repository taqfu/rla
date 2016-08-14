@extends('layouts.app')

@section('content')
<div id='timeline'>
<?php 
$old_date = 0; 
$old_time = 0; 
?>
@if (Auth::user())
@include ('Timeline.filter')
@endif
@forelse ($timeline_items as $timeline_item)
<div class='panel panel-default'>
    <div class='panel-body text-center'>
        @include ('Timeline.description')
    </div>
    <div>
        <a href="{{route('timeline.show', ['id'=>$timeline_item->id])}}">Permalink</a>
    </div>
</div>
@empty
<div class='text-center'>
Your timeline is empty. You need to create new achievements, comment or submit proof to existing achievements in order to fill your timeline.
</div>
@endforelse
</div>
@endsection
