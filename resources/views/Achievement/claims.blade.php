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
 - Claims
@endsection

@section('head')
<meta property="og:title" content="{{$main->name}} - Proofs" />
<meta property="og:description" content=" Do It! Prove It! claim listing for &quot;$main->name&quot;">
@endsection
@section('content')
<h1 class='text-center'>
    {{$main->name }}
</h1>
@include ('Achievement.menu', ['id'=>$main->id, 'url'=>$main->url, active_item'=>'claims'])
@include ('Achievement.header')
<h4 class='margin-left'>
    {{count ($claims)}} claims
</h4>
@if (count($claims)>0)
<ul>
@endif
@forelse ($claims as $claim)
    <?php
    if (Auth::guest()){
        $timestamp = date(Config::get('rla.timestamp_format') . ' e', strtotime($claim->created_at));
    } else if (Auth::user()){
        $timestamp = date(Config::get('rla.timestamp_format'),
          User::local_time(Auth::user()->timezone, strtotime($claim->created_at)));
    }
    ?>
    <li>
            <a href="{{route('user.show', ['id'=>$claim->user_id])}}">{{$claim->user->username}}</a>
            - {{interval($claim->created_at, 'now')}} ago
    </li>
@empty
<div class='margin-left lead'>
    No one has claimed to have completed this achievement yet.
</div>

@endforelse
@if (count($claims)>0)
</ul>
@endif
@endsection
