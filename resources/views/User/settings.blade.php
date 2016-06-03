
@extends('layouts.app')
@section('content')
@include ('User.menu', ['active'=>'settings'])
{{$_SERVER['SERVER_NAME']}}
<h4>Password</h4>
<form method="POST" action="{{route('settings.password')}}">
    <div>
    @if ($errors->get('old') || $errors->get('new') || $errors->get('confirm') || $errors->get('success'))
        @foreach ($errors->get('confirm') as $error)
            <div>{{$error}}</div>
        @endforeach
        @foreach ($errors->get('old') as $error)
            <div>{{$error}}</div>
        @endforeach
        @foreach ($errors->get('new') as $error)
            <div>{{$error}}</div>
        @endforeach
        @foreach ($errors->get('success') as $error)
            <div>{{$error}}</div>
        @endforeach
    @endif
    {{csrf_field()}}
    {{ method_field('PUT') }}
    </div>
    <div id='change_password' class='inline'>
        <div class='inline'>
        <label for='old_password'>Old Password:</label>
        <input type='password' name='old' id='old_password' />
        </div>
        <div  class='inline'>
        <label for='new_password'>New Password:</label>
        <input type='password' name='new' id='new_password' />
        </div>
        <div class='inline'>
        <label for='new_password_confirm'>Confirm Password:</label>
        <input type='password' name='new_confirmation' id='new_password_confirm' />
        </div>

        <input type='submit' value='Change Password'/>
    </div>
</form>
<!--
<h4>E-mail Address</h4>
<p>
    Your e-mail address is:
    @if (empty(Auth::user()->email))
        None
    @else
        {{Auth::user()->email}}
    @endif
</p>
<form method="POST" action="{{route('settings.email')}}">
<div>
@if ($errors->get('email'))
    @foreach ($errors->get('email') as $error)
        <div>{{$error}}</div>
    @endforeach
@endif
</div>
{{csrf_field()}}
{{ method_field('PUT') }}
<input type='email' name='email' />
<input type='submit' value='Change E-mail' />
</form>
-->
<h4>Tme Zone</h4>
<p>
Your time-zone is: {{Auth::user()->timezone}}
</p>
<form method="POST" action="{{route('settings.timezone')}}">
<div>
@if ($errors->get('timezone'))
    @foreach ($errors->get('timezone') as $error)
        <div>{{ $error }}</div>
    @endforeach
@endif
</div>
{{ csrf_field() }}
{{ method_field('PUT') }}
<select name='timezone'>
<?php
$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
var_dump($tzlist);

    foreach($tzlist as $tz){
        echo "<option ";
        if ($tz == Auth::user()->timezone){
            echo "selected";
        }
        echo ">$tz</option>";
    }
?>
</select>
<input type='submit' value='Change Time Zone' />
</form>

@endsection
