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
@endif
<div id='achievement-listing'>
    @include ('Achievement.filter', ['type'=>'index'])
    <div class='container-flexible'>
        <div class='row'>
            <div class='col-xs-1'></div>
            <div class='col-xs-10'>
                <table class='table table-bordered table-hover'>
                    @foreach ($achievements as $achievement)
                       @include('Achievement.row')
                    @endforeach
                </table>
            <div class='col-xs-1'></div>
    </div>
</div>
@endsection
