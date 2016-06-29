
<?php
  use App\Achievement;
  use App\Follow;
  use App\User;
?>
@extends('layouts.app')
@section('title')
    - Your Bucket List
@endsection
@section ('head')
     <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class='margin-left lead'>
    You're not logged in, but this is where you would place all the things you want to accomplish.
    <a href="{{ url('/login') }}">Login</a> or <a href="{{ url('/register') }}">register</a> now to start your own bucket list!
</div>
@endsection
