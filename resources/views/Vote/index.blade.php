@extends('layouts.app')
@section('content')
@foreach($proofs as $proof)
<div>
    @if ($proof->vote)
        <div style='background-color:green;width:20px;height:20px;float:left;text-align:center;font-weight:bold;'>
            @if ($proof->vote->vote_for)
                &#10004;
            @endif
        </div>
        <div style='background-color:red;width:20px;height:20px;float:left;text-align:center;font-weight:bold;'>
            @if (!$proof->vote->vote_for)
                &#10004;
            @endif
        </div>
    @endif
    <a href="{{$proof->url}}">{{$proof->achievement->name}}</a> ({{$proof->user->name}}) 
</div>
@endforeach
       
@endsection
