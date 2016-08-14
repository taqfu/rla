<?php use App\User; ?>
@extends('layouts.app')
@section('title')
 - {{$profile->username}} - Comments
@endsection

@section('content')
@include ('User.header')
@include ('User.menu', ['active'=>'comments'])
<div id='user-comments'>
    @forelse($comments as $comment)
    <div class='well'>
    <?php
        $timestamp = Auth::user()
          ? $timestamp = date(Config::get('rla.timestamp_format'), User::local_time(Auth::user()->timezone, strtotime($comment->created_at)))
          : date(Config::get('rla.timestamp_format') . ' e', strtotime($comment->created_at));
    ?>
        <div>
        <span  title='{{$timestamp}}'>{{interval($comment->created_at, "now")}} ago</span> -
        @if ($comment->achievement_id>0)
        <a href="{{route('achievement.discussion', ['url'=>$comment->achievement->url])}}">
            "{{$comment->achievement->name}}" Discussion Page
        </a>
        @elseif ($comment->proof_id>0)
        <a href="{{route('achievement.show', ['url'=>$comment->proof->achievement->url])}}#{{$comment->proof_id}}">
            "{{$comment->proof->achievement->name}}" Profile Page
        </a>
        @elseif ($comment->vote_id>0)
        <a href="{{route('proof.show', ['id'=>$comment->vote->proof_id])}}">
            "{{$comment->vote->achievement->name}}" Proof #{{$comment->Vote->proof_id}}'s Profile Page
        </a>
        @endif
        </div>
        <div class='comment-content' >
            {{$comment->comment}}
        </div>
    </div>
    @empty
        <div class='container'>
        This person has not commented yet.
        </div>
    @endforelse
</div>
@endsection
