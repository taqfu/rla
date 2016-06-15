<?php use App\User; ?>
@extends('layouts.app')
@section('title')
 - {{$profile->username}} - Comments
@endsection

@section('content')
    @include ('User.menu', ['active'=>'comments'])
    @forelse($comments as $comment)
    <?php
        $timestamp = Auth::user()
          ? $timestamp = date('m/d/y h:i:sA', User::local_time(Auth::user()->timezone, strtotime($comment->created_at)))
          : date('m/d/y h:i:sA e', strtotime($comment->created_at));
    ?>
        <div>
        <span  title='{{$timestamp}}'>{{interval($comment->created_at, "now")}} ago</span> - 
        @if ($comment->achievement_id>0)
        <a href="{{route('discussion', ['id'=>$comment->achievement_id])}}">
            "{{$comment->achievement->name}}" Discussion Page
        </a>
        @elseif ($comment->proof_id>0)
        <a href="{{route('achievement.show', ['id'=>$comment->proof->achievement_id])}}#{{$comment->proof_id}}">
            "{{$comment->proof->achievement->name}}" Profile Page
        </a>
        @elseif ($comment->vote_id>0)
        <a href="{{route('proof.show', ['id'=>$comment->vote->proof_id])}}">
            "{{$comment->vote->achievement->name}}" Proof #{{$comment->Vote->proof_id}}'s Profile Page
        </a>
        @endif
        </div>
        <div class='margin-bottom margin-left'>
            {{$comment->comment}}
        </div>
    @empty
        <div class='margin-left'>
        This person has not commented yet.
        </div>
    @endforelse
@endsection
