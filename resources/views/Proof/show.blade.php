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
<link rel=”image_src” href=”{{$proof->url}}.png” />
@endsection
@section('content')
<h1>
    <a href="{{route('achievement.show', ['id'=>$proof->achievement->id])}}" class='no_link
        @if ($proof->achievement->status==0)
            denied
        @elseif ($proof->achievement->status==1)
            approved
        @elseif ($proof->achievement->status==2)
            pending
        @endif
    '>
        {{$proof->achievement->name}}
    </a>

</h1>
<div id='proof_statement'>
Proof (<a href="{{$proof->url}}">{{$proof->url}}</a>) submitted by
@if (Auth::user() && Auth::user()->id==$proof->user_id)
    you
@else
<a href="{{route('user.show', ['id'=>$proof->user_id])}}">{{$proof->user->username}}</a>
@endif
 on
    @if (Auth::guest())
    {{date('m/d/y h:i:s', strtotime($proof->created_at))}}
    @elseif (Auth::user())
    {{date('m/d/y h:i:s', User::local_time(Auth::user()->timezone, strtotime($proof->created_at)))}}
    @endif
.</div>
<div id='proof_status'>
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
<div class='margin-left'>
    <i>
      @if (Auth::guest())
      {{ date('H:i', strtotime($vote->created_at)) }}
      @elseif (Auth::user())
      {{ date('H:i', User::local_time(Auth::user()->timezone, strtotime($vote->created_at))) }}
      @endif
    </i> -
    <a href="{{route('user.show', ['id'=>$vote->user->id])}}">{{$vote->user->username}}</a> voted
    @if ($vote->vote_for)
        for this proof.
    @else
        against this proof.
    @endif
@if (Proof::can_user_comment($proof->id))
    <button id='show_new_comment{{$vote->id}}' class='text_button show_new_comment'>[ Comment ]</button>
    @if ($vote->comments)
        <input type='button' id='show_comments{{$vote->id}}' class='show_comments text_button margin-left' value='[ + ]' />
    @endif
    </div>
    @if (Proof::can_user_comment($proof->id))
        @include ('Comment.create', ['table'=>'vote', 'table_id'=>$vote->id, 'show'=>false])
    @endif
@else
    </div>
@endif
@if (count($vote->comments)>0)
<div class='padding-left'>
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
