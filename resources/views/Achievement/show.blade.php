<?php
    use \App\Achievement;
    use \App\Proof;
    use \App\User;
?>

@extends('layouts.app')

@section('title') 
 -  @if (strlen($main->name)>61)
    {{substr($main->name, 0, 61)}}...
    @else
    {{$main->name}}
    @endif
@endsection


@section('content')
@include ('Achievement.header')
@include ('Achievement.menu', ['id'=>$main->id, 'active_item'=>'info'])

@if ((Auth::user() && Achievement::can_user_submit_proof($main->id))
        && ((Auth::user()->id==$main->created_by && $main->status==0)
        || (Auth::user()->id!=$main->created_by && $main->status!=2)) )
    @include ('Proof.create', ['achievement_id'=>$main->id])
@endif

<?php $old_date = 0; ?>
@foreach ($proofs as $proof)
<?php
if (Auth::guest()){
  $date = date('m/d/y', strtotime($proof->created_at));
} else if (Auth::user()){
  $date = date('m/d/y', User::local_time(Auth::user()->timezone, strtotime($proof->created_at)));
}
?>
    @if ($date != $old_date)
        <h3 >{{$date}}</h3>
        <?php $old_date = $date; ?>
    @endif
<div class='achievement_proof margin-left inline'>
    <div class='inline'>
        <a href="{{route('user.show', ['id'=>$proof->user->id])}}">{{$proof->user->username}}</a>
        submitted <a href="{{route('proof.show', ['id'=>$proof->id])}}">proof</a> of completion.
        (<a href="{{$proof->url}}">{{$proof->url}}</a>)  -
        @if ($proof->status==0)
        <span class='fail'>Denied (
        @if (Auth::guest())
        {{date('m/d/y', strtotime($proof->updated_at))}}
        @elseif (Auth::user())
        {{date('m/d/y', User::local_time(Auth::user()->timezone, strtotime($proof->updated_at)))}}
        @endif
        )</span>

        @elseif ($proof->status==1)
        <span class='pass'>Approved (
          @if (Auth::guest())
          {{date('m/d/y', strtotime($proof->updated_at))}}
          @elseif (Auth::user())
          {{date('m/d/y', User::local_time(Auth::user()->timezone, strtotime($proof->updated_at)))}}
          @endif

          )</span>
        @elseif ($proof->status==2)
        <i>
            Pending Approval - {!!Proof::min_time_to_vote($proof->id)!!} left to vote. {{Proof::max_time_to_vote($proof->id)}} max.
            <?php $is_it_passing = Proof::passing_approval($proof->id); ?>
            @if ($is_it_passing)
                (<span class='pass'>Passing</span>)
            @else
                (<span class='fail'>Failing</span>)
            @endif
        </i>
        @endif
        @if (Proof::can_user_comment($proof->id))
            <button id='show_new_comment{{$proof->id}}' class='text_button show_new_comment'>[ Comment ]</button>
        @endif
    </div>
@include ('Vote.query', ['create_only'=>false])
@if ($proof->comments)
    <input type='button' id='show_comments{{$proof->id}}' class='show_comments text_button margin-left' value='[ + ]' />
@endif
@if (Proof::can_user_comment($proof->id))
    @include ('Comment.create', ['table'=>'proof', 'table_id'=>$proof->id, 'show'=>false])

@endif
@if (count($proof->comments)>0)
<div class='padding-left'>
    <input type='button' id='hide_comments{{$proof->id}}' class='hide_comments text_button' value='[ - ]' />
    <div id='comments{{$proof->id}}'>
        @foreach ($proof->comments as $comment)
            @include ('Comment.show', ['comment'=>$comment])
        @endforeach
    </div>
</div>
@endif
</div>
@endforeach
@endsection
