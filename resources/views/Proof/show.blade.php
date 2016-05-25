<?php 
    use \App\Proof; 
?>
@extends('layouts.app')
@section('content')
<h3 style='margin-bottom:4px;'>
Proof (<a href="{{$proof->url}}">{{$proof->url}}</a>) submitted by 

@if (Auth::user() && Auth::user()->id==$proof->user_id)
    you
@else
<a href="{{route('user.show', ['id'=>$proof->user_id])}}">{{$proof->user->name}}</a> 
@endif
 for <a href="{{route('achievement.show', ['id'=>$proof->achievement->id])}}">{{$proof->achievement->name}}</a>
</h3>
<div style='font-style:italic;margin-bottom:16px;margin-top:0px;'>
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
</div>
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
    <span style='font-style:italic;'>{{ date('H:i', strtotime($vote->created_at)) }}</span> - 
    <a href="{{route('user.show', ['id'=>$vote->user->id])}}">{{$vote->user->name}}</a> voted 
@if ($vote->vote_for)
    for
@else
    against
@endif
@if (Proof::can_user_comment($proof->id))
    <button id='show_new_comment{{$vote->id}}' class='show_new_comment'>Comment</button>
@if ($vote->comments)
    <input type='button' id='show_comments{{$vote->id}}' class='show_comments text_button' value='[ + ]' style='margin-left:16px;'/>
@endif
</div>
@if (Proof::can_user_comment($proof->id))
    @include ('Comment.create', ['table'=>'vote', 'table_id'=>$vote->id], 'show'=>false)
@endif
@endif
@if (count($vote->comments)>0)
<div style='padding-left:16px;'>
    <input type='button' id='hide_comments{{$vote->id}}' class='hide_comments text_button' value='[ - ]' />
    <div id='comments{{$vote->id}}'>
        @foreach ($vote->comments as $comment)
            @include ('Comment.show', ['comment'=>$comment])
        @endforeach
    </div>
</div>
@endif 
@endforeach
@endsection
