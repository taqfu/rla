
@extends('layouts.app')
@section('content')
<h3>
Proof #{{$proof->id}} submitted by 

@if (Auth::user() && Auth::user()->id==$proof->user_id)
    you
@else
<a href="{{route('user.show', ['id'=>$proof->user_id])}}">{{$proof->user->name}}</a> 
@endif
 for <a href="{{route('achievement.show', ['id'=>$proof->achievement->id])}}">{{$proof->achievement->name}}</a>
</h3>
<h4>
@if ($proof->status==0)
    Denied
@elseif ($proof->status==1)
    Approved
@elseif ($proof->status==2)
    Pending Approval - 
    @if ($passing)
        <span style='color:green;'>Passing</span>
    @else
        <span style='color:red;'>Failing </span>
    @endif
@endif
 - For ({{$num_of_for_votes}}) / Against ({{$num_of_against_votes}})
</h4>
<?php $old_date = 0; ?>
@foreach ($votes as $vote)
    <?php $date = date('m/d/y', strtotime($vote->created_at)); ?>
    @if ($date!=$old_date)
        <div style='font-weight:bold;'>{{$date}}</div>
        <?php $old_date = $date; ?>
    @endif
<div style='margin-left:16px;'>
    {{ date('g:i', strtotime($vote->created_at)) }}
    <a href="{{route('user.show', ['id'=>$vote->user->id])}}">{{$vote->user->name}}</a> voted 
@if ($vote->vote_for)
    for
@else
    against
@endif
</div>
@endforeach
@endsection
