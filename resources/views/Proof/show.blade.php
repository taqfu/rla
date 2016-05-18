<?php use \App\Proof; ?>
@extends('layouts.app')
@section('content')
<h3>
Proof (<a href="{{$proof->url}}">{{$proof->url}}</a>) submitted by 

@if (Auth::user() && Auth::user()->id==$proof->user_id)
    you
@else
<a href="{{route('user.show', ['id'=>$proof->user_id])}}">{{$proof->user->name}}</a> 
@endif
 for <a href="{{route('achievement.show', ['id'=>$proof->achievement->id])}}">{{$proof->achievement->name}}</a>
</h3>
<h4>
@if ($proof->status==0)
    <span style='color:red;'>Denied</span>
@elseif ($proof->status==1)
    <span style='color:green;'>Approved</span>
@elseif ($proof->status==2)
    Pending Approval - 
    @if ($passing)
        <span style='color:green;'>Passing</span>
    @else
        <span style='color:red;'>Failing </span>
    @endif
@endif
 - For ({{$num_of_for_votes}}) / Against ({{$num_of_against_votes}})
@if ($proof->status==2)
- {!!Proof::min_time_to_vote($proof->id)!!} left to vote. {{Proof::max_time_to_vote($proof->id)}} max.
@endif
</h4>
<div>
@include ('Vote.query', ['create_only'=>true])
</div>
<?php $old_date = 0; ?>
@foreach ($votes as $vote)
    <?php $date = date('m/d/y', strtotime($vote->created_at)); ?>
    @if ($date!=$old_date)
        <div style='font-weight:bold;clear:both;'>{{$date}}</div>
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
