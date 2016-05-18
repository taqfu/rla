<?php 
    use \App\Achievement;
    use \App\Proof;
?>

@extends('layouts.app')
@section('content')
<h1 style='text-align:center;'>
    {{$main->name }} 
</h1>
@if ($main->status==0)
<h1 style='color:red;text-aLign:center;'>Denied!</h1>
@endif
@if ((Auth::user() && Achievement::can_user_submit_proof($main->id))
        && ((Auth::user()->id==$main->created_by && $main->status==0)
        || (Auth::user()->id!=$main->created_by && $main->status==1)) )
    @include ('Proof.create', ['achievement_id'=>$main->id])
@endif    
<div> 
    Submitted: {{ date('m/d/y h:iA', strtotime($main->created_at))}} by <a href="{{route('user.show', ['id'=>$main->user->id])}}">{{$main->user->name}}</a>
    @if ($main->status==2)
        <span style='font-style:italic;'>(Pending Approval)</span>
    @endif
</div>



@foreach ($proofs as $proof)
<div style='clear:both;'>
<div style='float:left;'>
    <a href="{{route('user.show', ['id'=>$proof->user->name])}}">{{$proof->user->name}}</a> submitted <a href="{{route('proof.show', ['id'=>$proof->id])}}">proof</a> of completion on {{date('M d, Y H:i', strtotime($proof->created_at))}}. 
    (<a href="{{$proof->url}}">{{$proof->url}}</a>)  - 
    @if ($proof->status==0)
    <span style='color:red;'>Denied</span> 
    <span style='font-style:italic;'>{{date('m/d/y', strtotime($proof->updated_at))}}</span>
    
    @elseif ($proof->status==1)
    <span style='color:green;'>Approved </span> 
    <span style='font-style:italic;'>{{date('m/d/y', strtotime($proof->updated_at))}}</span>
    @elseif ($proof->status==2)
    <span style='font-style:italic;'>
        Pending Approval - {!!Proof::min_time_to_vote($proof->id)!!} left to vote. {{Proof::max_time_to_vote($proof->id)}} max.
        <?php $is_it_passing = Proof::passing_approval($proof->id); ?>
        @if ($is_it_passing)
            (<span style='color:green;'>Passing</span>)
        @else
            (<span style='color:red;'>Failing</span>)
        @endif
    </span>
    @endif
</div>
@include ('Vote.query', ['create_only'=>false])
</div>
@endforeach
@endsection
