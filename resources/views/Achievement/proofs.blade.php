
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
@include ('Achievement.menu', ['id'=>$main->id, 'url'=>$main->url, 'active_item'=>'proofs'])
@include ('Achievement.header')
<h4 class=''>
    {{count ($proofs)}} proofs
</h4>
<table class='table table-bordered table-hover'>
    <tr><th>
        @if ($sort=="created_at asc")
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'created_at desc'])}}"><em>
            When &uarr;

        </em></a>
        @elseif ($sort=="created_at desc")
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'created_at asc'])}}"><em>
            When &darr;
        </em></a>

        @else
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'created_at desc'])}}">
        @if ($sort==null)
            <em>
        @endif
            When
        @if ($sort==null)
            &darr;
            </em>
        @endif
        </a>
        @endif
    </th>
    <th>
        @if ($sort=="id asc")
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'id desc'])}}"><em>
            Proof &darr;

        </em></a>
        @elseif ($sort=="id desc")
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'id asc'])}}"><em>
            Proof &uarr;
        </em></a>

        @else
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'id asc'])}}">
            Proof
        </a>
        @endif
    </th>
    <th>
        User
    </th>
    <th>
        @if ($sort=="url asc")
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'url desc'])}}"><em>
            URL &darr;

        </em></a>
        @elseif ($sort=="url desc")
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'url asc'])}}"><em>
            URL &uarr;
        </em></a>

        @else
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'url asc'])}}">
            URL
        </a>
        @endif
    </th>
    <th>
        @if ($sort=="status asc")
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'status desc'])}}"><em>
            Status &darr;

        </em></a>
        @elseif ($sort=="status desc")
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'status asc'])}}"><em>
            Status &uarr;
        </em></a>

        @else
        <a href="{{route('achievement.showProofs', ['id'=>$main->id, 'sort'=>'status asc'])}}">
            Status
        </a>
        @endif
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
        <a href="{{route('user.show', ['username'=>$proof->user->username])}}">{{$proof->user->username}}</a>
    </td>
    <td>
        <A target='_blank' href="{{$proof->url}}">{{$proof->url}}</a>
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
