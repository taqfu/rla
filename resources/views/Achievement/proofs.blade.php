
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
 - Proofs
@endsection

@section('head')
<meta property="og:title" content="{{$main->name}} - Proofs" />
<meta property="og:description" content=" Do It! Prove It! proof listing for &quot;$main->name&quot;">
@endsection
@section('content')
<h1 class='text-center'>
    {{$main->name }}
</h1>
@include ('Achievement.menu', ['id'=>$main->id, 'active_item'=>'proofs'])
@include ('Achievement.header')
<h4 class=''>
    {{count ($proofs)}} proofs
</h4>
<table class='table table-bordered table-hover'> 
    <tr><th>
       When
    </th>
    <th>
        Proof
    </th>
    <th>
        User
    </th>
    <th>
       URL
    </th>
    <th>
        Status
    </th></tr>
@foreach ($proofs as $proof)
    <?php
    if (Auth::guest()){
        $timestamp = date(Config::get('rla.timestamp_format') . ' e', strtotime($proof->created_at));
    } else if (Auth::user()){
        $timestamp = date(Config::get('rla.timestamp_format'), 
          User::local_time(Auth::user()->timezone, strtotime($proof->created_at)));
    }
    ?>
    <tr><td>
        {{interval($proof->created_at, 'now')}} ago
    </td>
    <td>
        <a href="{{route('proof.show', ['id'=>$proof->id])}}">Proof #{{$proof->id}}</a>
    </td>
    <td>
        <a href="{{route('user.show', ['id'=>$proof->user_id])}}">{{$proof->user->username}}</a>
    </td>
    <td>
        <A href="{{$proof->url}}">{{$proof->url}}</a>
    </td>
    <td>
        @if ($proof->status==0)
        <span class='fail'>Denied</span>
        @elseif($proof->status==1)
        <span class='pass'>Approved</span>
        @elseif($proof->status==2)
        Pending Approval
        @elseif($proof->status==4)
        Canceled
        @else
            {{$proof->status}}
        @endif    
    </tr>
    
@endforeach
@endsection
