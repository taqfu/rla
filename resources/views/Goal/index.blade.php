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
@forelse($goals as $goal)
{{$goal}}
@empty
<div class='margin-left lead'>
    You do not have any items in your bucket list. Add some today!
</div>
@endforelse
@endsection
