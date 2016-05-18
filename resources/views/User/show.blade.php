
@extends('layouts.app')
@section('content')
<h1 style='text-align:center;'>
    {{$username}}
</h1>
<?php $old_date = 0; ?>
@foreach ($proofs as $proof)
    <?php $date = date('m/d/y', strtotime($proof->created_at)) ?>
    
    @if ($old_date!=$date)
        <h3>{{$date}}</h3>
        <?php $old_date = $date; ?>
    @endif
<div>
    {{$proof->achievement->name}} (<a href='{{$proof->url}}'>{{$proof->url}}</a>) 
</div>
@endforeach
@endsection
