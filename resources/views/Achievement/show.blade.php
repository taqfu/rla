    <?php use \App\Vote; ?>
@extends('layouts.app')
@section('content')
<h1 style='text-align:center;'>
    {{$main->name }} 
</h1>
<div> 
    Submitted: {{ date('m/d/y h:iA', strtotime($main->created_at))}} by {{$main->user->name}}
    @if ($main->status==2)
        <a href="{{route('vote.index')}}" style='font-style:italic;'>(Pending Approval)</a>
    @endif
</div>

@if (Auth::user() && Auth::user()->id!=$main->created_by)
    @include ('Proof.create', ['achievement_id'=>$main->id])
@endif    


@foreach ($proofs as $proof)
{{$proof->user->name}} - <a href="{{$proof->url}}">{{$proof->url}}</a>  - 
@if ($proof->status==0)
<span style='color:red;'>Denied</span><span style='font-style:italic;'>{{date('m/d/y', strtotime($proof->updated_at))}}</span>

@elseif ($proof->status==1)
<span style='color:green;'>Approved </span> <span style='font-style:italic;'>{{date('m/d/y', strtotime($proof->updated_at))}}</span>
@elseif ($proof->status==2)
<span style='font-style:italic;'>Pending</span>
    <?php
        $vote = Vote::where('proof_id', $proof->id)->where('user_id', Auth::user()->id)->first();
    ?>
    @if ($vote==null)
        @include ('Vote.create')
    @elseif ($vote!=null)
        @if (!$vote->vote_for)
            <span style='font-weight:bold;color:red;'>
        @else
            <span style='font-weight:bold;color:green;'>
        @endif
        Voted 
        @if ($vote->vote_for)
            for
        @else
            against
        @endif
        </span>
    @endif
@endif

@endforeach
@endsection
