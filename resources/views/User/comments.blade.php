@extends('layouts.app')

@section('content')
    @include ('User.menu', ['active'=>'comments'])
    @foreach($comments as $comment)
        <div class='margin-top2'>
        @if ($comment->achievement_id>0)
        <a href="{{route('discussion', ['id'=>$comment->achievement_id])}}">
            From discussion page for "{{$comment->achievement->name}}":
        </a>
        @elseif ($comment->proof_id>0)
        <a href="{{route('achievement.show', ['id'=>$comment->proof->achievement_id])}}">
            From achievement profile page for "{{$comment->proof->achievement->name}}":
        </a>
        @elseif ($comment->vote_id>0)
        <a href="{{route('proof.show', ['id'=>$comment->vote->proof_id])}}">
            From proof profile for achievement "{{$comment->vote->achievement->name}}":
        </a>
        @endif
        </div>
        <div>
            {{$comment->comment}}
        </div>
    @endforeach
@endsection
