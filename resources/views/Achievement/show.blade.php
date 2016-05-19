<?php 
    use \App\Achievement;
    use \App\Proof;
?>

@extends('layouts.app')
@section('content')
<h1 class='
    @if ($main->status==0)
        denied
    @elseif ($main->status==1)
        approved
    @elseif ($main->status==2)
        pending
    @endif       
'>
    {{$main->name }} 
</h1>
<div style='margin-bottom:16px;font-style:italic;'> 
    Submitted: {{ date('m/d/y h:iA', strtotime($main->created_at))}} by <a href="{{route('user.show', ['id'=>$main->user->id])}}">{{$main->user->name}}</a>
    @if ($main->status==2)
        - <span class='pending'>(Pending Approval)</span>
    @elseif ($main->status==0)
        - <span class='denied'>(Denied)</span>
    @endif
</div>

@if ((Auth::user() && Achievement::can_user_submit_proof($main->id))
        && ((Auth::user()->id==$main->created_by && $main->status==0)
        || (Auth::user()->id!=$main->created_by && $main->status==1)) )
    @include ('Proof.create', ['achievement_id'=>$main->id])
@endif    

<?php $old_date = 0; ?>
@foreach ($proofs as $proof)
<?php $date = date('m/d/y', strtotime($proof->created_at)); ?>
    @if ($date != $old_date)
        <h3 style='clear:both;padding-top:16px;'>{{$date}}</h3>
        <?php $old_date = $date; ?>
    @endif
<div style='clear:both;margin-left:16px;'>
    <div style='float:left;'>
        <!--{{date('H:i', strtotime($proof->created_at))}}-->
        <a href="{{route('user.show', ['id'=>$proof->user->name])}}">{{$proof->user->name}}</a>
        submitted <a href="{{route('proof.show', ['id'=>$proof->id])}}">proof</a> of completion. 
        (<a href="{{$proof->url}}">{{$proof->url}}</a>)  - 
        @if ($proof->status==0)
        <span class='denied'>Denied ({{date('m/d/y', strtotime($proof->updated_at))}})</span>
        
        @elseif ($proof->status==1)
        <span class='approved'>Approved ({{date('m/d/y', strtotime($proof->updated_at))}})</span>
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
