<?php
use App\User;
?>
@extends('layouts.app')

@section('title')
 - {{$profile->username}}
@if (substr($profile->username, -1)=="s")
'
@else
's
@endif
 achievements
@endsection

@section('content')
@include ('User.menu', ['active'=>'profile'])
@include ('User.header')
@endsection
