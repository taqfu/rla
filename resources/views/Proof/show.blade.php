<?php
    use \App\Proof;
    use App\User;
?>
@extends('layouts.app')
@section('title')
 -  @if (strlen($proof->achievement->name)>61)
    {{substr($proof->achievement->name, 0, 61)}}...
    @else
    {{$proof->achievement->name}}
    @endif
@endsection
@section('head')
<meta property="og:description" content="
  @if (substr($proof->user->name, -1, 1)=='s')
    {{$proof->user->name}}'
  @else
    {{$proof->user->name}}'s
  @endif  
    proof for completing '{{$proof->achievement->name}}' - 

  @if ($proof->status==0)
    Denied!
  @elseif ($proof->status==1)
    Approved
  @elseif ($proof->status==2)
    Pending Approval
  @elseif ($proof->status==4)
    Canceled
  @endif
" />
@endsection
@section('content')
<h1 class='text-center'>
        {{$proof->achievement->name}}
</h1>

<div class='well'>
<div id='proof-statement'>
    Proof (<a href="{{$proof->url}}">{{$proof->url}}</a>) submitted by
    @if (Auth::user() && Auth::user()->id==$proof->user_id)
     you
    @else
     <a href="{{route('user.show', ['id'=>$proof->user_id])}}">{{$proof->user->username}}</a>
    @endif
     on
        @if (Auth::guest())
        {{date('m/d/y h:i:s e', strtotime($proof->created_at))}}.
        @elseif (Auth::user())
        {{date('m/d/y h:i:s', User::local_time(Auth::user()->timezone, strtotime($proof->created_at)))}}.
        @endif
</div>
<div id='proof-status' class='inline'>
&nbsp;
@if ($proof->status==0)
    <span class='fail'>Denied</span>
@elseif ($proof->status==1)
    <span class='pass'>Approved</span>
@elseif ($proof->status==2)
    Pending Approval -
    @if ($passing)
        <span class='pass'>Passing</span>
    @else
        <span class='fail'>Failing </span>
    @endif
@elseif ($proof->status==4)
    Canceled
@endif
 - For ({{$num_of_for_votes}}) / Against ({{$num_of_against_votes}})
@if ($proof->status==2)
- {!!Proof::min_time_to_vote($proof->id)!!} left to vote. {{Proof::max_time_to_vote($proof->id)}} max.
@endif
@include ('Vote.query', ['create_only'=>true])
@if (Auth::user() && $proof->user_id == Auth::user()->id && $proof->status==2)
    @include ('Proof.destroy')
@endif
</div>
</div>
<?php $old_date = 0; ?>
@foreach ($votes as $vote)
    <?php
    if (Auth::guest()){
    $date = date('m/d/y', strtotime($vote->created_at));
  } else if (Auth::user()){
    $date = date('m/d/y', User::local_time(Auth::user()->timezone, strtotime($vote->created_at)));
  }
    ?>
    @if ($date!=$old_date)
        <div><strong>{{$date}}</strong></div>
        <?php $old_date = $date; ?>
    @endif
<div class='proof-votes well'>
    <i>
      @if (Auth::guest())
      {{ date('h:i:sA e', strtotime($vote->created_at)) }}
      @elseif (Auth::user())
      {{ date('h:i:sA', User::local_time(Auth::user()->timezone, strtotime($vote->created_at))) }}
      @endif
    </i> -
    <a href="{{route('user.show', ['id'=>$vote->user->id])}}">{{$vote->user->username}}</a> voted
    @if ($vote->vote_for)
        for this proof.
    @else
        against this proof.
    @endif
@if (Proof::can_user_comment($proof->id))
    <button id='show-new-comment{{$vote->id}}' class='btn-link show-new-comment'>[ Comment ]</button>
    @if ($vote->comments)
        <input type='button' id='show-comments{{$vote->id}}' class='show-comments btn-link margin-left' value='[ + ]' />
    @endif
    @if (Proof::can_user_comment($proof->id))
        @include ('Comment.create', ['table'=>'vote', 'table_id'=>$vote->id, 'show'=>false])
    @endif
@else
<div class='proof-vote-comments padding-left inline'>
    <input type='button' id='hide_comments{{$vote->id}}' class='hide_comments btn-link' value='[ - ]' />
    <div id='comments{{$vote->id}}'>
        @foreach ($vote->comments as $comment)
            @include ('Comment.show', ['comment'=>$comment])
        @endforeach
    </div>
</div>
@endif
@endforeach
@endsection
