<?php 
    use \App\Achievement;
    use \App\Proof;
?>

@extends('layouts.app')
@section('content')
@include ('Achievement.menu', ['id'=>$main->id, 'active_item'=>'info'])
@include ('Achievement.header')

@if ((Auth::user() && Achievement::can_user_submit_proof($main->id))
        && ((Auth::user()->id==$main->created_by && $main->status==0)
        || (Auth::user()->id!=$main->created_by && $main->status!=2)) )
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
        @if (Proof::can_user_comment($proof->id))
            <button id='show_new_comment{{$proof->id}}' class='show_new_comment'>Comment</button>
        @endif
    </div>
@include ('Vote.query', ['create_only'=>false])
@if ($proof->comments)
    <input type='button' id='show_comments{{$proof->id}}' class='show_comments text_button' value='[ + ]' style='margin-left:16px;'/>
@endif
</div>
@if (Proof::can_user_comment($proof->id))
    @include ('Comment.create', ['table'=>'proof', 'table_id'=>$proof->id, 'show'=>false])
    
@endif
@if (count($proof->comments)>0)
<div style='padding-left:16px;'>
    <input type='button' id='hide_comments{{$proof->id}}' class='hide_comments text_button' value='[ - ]' />
    <div id='comments{{$proof->id}}'>
        @foreach ($proof->comments as $comment)
            @include ('Comment.show', ['comment'=>$comment])
        @endforeach
    </div>
</div>
@endif 
@endforeach
@endsection
