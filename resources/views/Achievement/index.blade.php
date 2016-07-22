<?php
  use App\Achievement;
  use App\Follow;
  use App\User;
?>
@extends('layouts.app')
@section('title')
    - Achievements
@endsection
@section ('head')
     <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@if (Auth::user())
    @include ('Achievement.create')
@else
<div class='container text-center lead'><strong>
    <a href="{{url('/login')}}">Log in</a> or <a href="{{url('/register')}}">register</a> to create achievements.
</strong></div>
@endif
<div id='achievement-listing '>
    @include ("Achievement.sort")
    @include ('Achievement.filter', ['type'=>'index'])
    <div class='container-flexible'>
        <div class='row'>
            <div class='col-xs-1'></div>
            <div class='col-xs-10 text-center'>
                @if ($achievements->count())
                <table class='table table-bordered table-hover'>
                    @foreach ($achievements as $achievement)
                       @include('Achievement.row')
                    @endforeach
                </table>
                {!! $achievements->render() !!}
                @else
                <div class='lead'>
                    <div>
                        No achievements listed. 
                    </div>
                    <div><i>
                        (All achievements have been filtered out.)
                    </i></div>
                </div>
                @endif
            </div>
            <div class='col-xs-1'></div>
    </div>
</div>
@endsection
