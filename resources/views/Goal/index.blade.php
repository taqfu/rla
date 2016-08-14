@extends('layouts.app')
@section('title')
    - Your Bucket List
@endsection
@section ('head')
     <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div id='bucket-list'>
@include ('Goal.index-bare')
</div>
@endsection
