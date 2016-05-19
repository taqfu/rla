
@extends('layouts.app')
@section('content')
<h1 style='text-align:center;'>{{$username}}</h1>
<h3>Completed Achievements</h3>
<?php $old_date = 0; ?>
@foreach ($proofs as $proof)
    <?php $date = date('m/d/y', strtotime($proof->created_at)) ?>
   <!-- 
    @if ($old_date!=$date)
        <h3>{{$date}}</h3>
        <?php $old_date = $date; ?>
    @endif
    -->
    
<div style='margin-left:16px;'>
    <a  class='
        @if ($proof->achievement->status==0)
            denied
        @elseif ($proof->achievement->status==1)
            approved
        @elseif ($proof->achievement->status==2)
            pending
        @endif
    ' href="{{route('achievement.show', ['id'=>$proof->achievement->id])}}">{{$proof->achievement->name}}</a>
    (<a href='{{$proof->url}}'>Proof</a>)  - <a href="{{route('user.show', ['id'=>$proof->achievement->user->id])}}">{{$proof->achievement->user->name}}</a>
</div>
@endforeach
@endsection
