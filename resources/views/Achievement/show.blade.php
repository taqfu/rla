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

@section('head')
<meta property="og:title" content="{{$main->name}}" />
<meta property="og:description" content="Do It! Prove It! achievement profile for &quot;$main->name&quot; - Created by {{$main->user->username}} "/>
@endsection
@section('content')
<h1 class='text-center'>
    {{$main->name }}
</h1>
@include ('Achievement.menu', ['id'=>$main->id, 'active_item'=>'info'])
@include ('Achievement.header')


<?php $old_date = 0; ?>
@foreach ($proofs as $proof)
    <?php
    if (Auth::guest()){
      $date = date(Config::get('rla.date_format'), strtotime($proof->created_at));
      $timestamp = date(Config::get('rla.time_format') . ' e', strtotime($proof->created_at));
    } else if (Auth::user()){
      $date = date(Config::get('rla.date_format'), User::local_time(Auth::user()->timezone, strtotime($proof->created_at)));
      $timestamp = date(Config::get('rla.time_format'), User::local_time(Auth::user()->timezone, strtotime($proof->created_at)));
    }
    ?>
    @if ($date != $old_date)
        <h3 class=''>{{$date}}</h3>
        <?php $old_date = $date; ?>
    @endif
    <a name='proof{{$proof->id}}'></a>
    <div class='achievement-proof well row'>
        <div class='proof-timestamp '>{{$timestamp}}</div>
        <div class='inline'><a href="{{route('user.show', ['id'=>$proof->user->id])}}">{{$proof->user->username}}</a>
            submitted <a href="{{route('proof.show', ['id'=>$proof->id])}}">proof</a> of completion.
            (<a href="{{$proof->url}}">{{$proof->url}}</a>)  -
            @if ($proof->status==0)
            <span class='fail'>Denied (
            @if (Auth::guest())
            {{date(Config::get('rla.date_format'), strtotime($proof->updated_at))}}
            @elseif (Auth::user())
            {{date(Config::get('rla.date_format'), User::local_time(Auth::user()->timezone, strtotime($proof->updated_at)))}}
            @endif
            )</span>

            @elseif ($proof->status==1)
            <span class='pass'>Approved (
              @if (Auth::guest())
              {{date(Config::get('rla.date_format'), strtotime($proof->updated_at))}}
              @elseif (Auth::user())
              {{date(Config::get('rla.date_format'), User::local_time(Auth::user()->timezone, strtotime($proof->updated_at)))}}
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
                @if (Auth::user() && $proof->user_id == Auth::user()->id)
                    @include ('Proof.destroy')
                @endif
            @elseif ($proof->status==4)
            <i>
                Canceled
              @if (Auth::guest())
              {{date(Config::get('rla.date_format'), strtotime($proof->updated_at))}}
              @elseif (Auth::user())
              {{date(Config::get('rla.date_format'), User::local_time(Auth::user()->timezone, strtotime($proof->updated_at)))}}
              @endif
            </i>
            @endif
    @include ('Vote.query', ['create_only'=>false])
            @if (Proof::can_user_comment($proof->id))
                <button id='show-new-comment{{$proof->id}}' class='show-new-comment btn-link'>[ Comment ]</button>
            @endif
    @if (count($proof->comments)>0)
        <input type='button' id='show-comments{{$proof->id}}' class='show-comments hidden btn-link btn-lg' value='[ + ]' />
    @endif
        </div>
    @if (Proof::can_user_comment($proof->id))
        @include ('Comment.create', ['table'=>'proof', 'table_id'=>$proof->id, 'show'=>false])

    @endif
    @if (count($proof->comments)>0)
    <div class='achievement-proof-comments margin-left'>
        <input type='button' id='hide_comments{{$proof->id}}' class='hide_comments btn-link btn-lg' value='[ - ]' />
        <div id='comments{{$proof->id}}' class='margin-left'>
            @foreach ($proof->comments as $comment)
                @include ('Comment.show', ['comment'=>$comment])
            @endforeach
        </div>
    </div>
    @endif
    </div>
@endforeach
@endsection
