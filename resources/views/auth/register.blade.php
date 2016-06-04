@extends('layouts.app')
@section('title')
 - Register
@endsection
@section('content')
<form  method="POST" action="{{ url('/register') }}">
@foreach ($errors->all() as $error)
    <div>{{$error}}</div>
@endforeach
    {!! csrf_field() !!}
    <div>
        <label for="username">Username</label>
        <div>
            <input type="text" name="username" value="{{ old('username') }}" id="username">
            @if ($errors->has('username'))
                <strong>{{ $errors->first('username') }}</strong>
            @endif
        </div>
    </div>
<!--
    <div>
        <label for="email">E-Mail Address (optional)</label>
        <div>
            <input type="email" name="email" value="{{ old('email') }}" id="email">
            @if ($errors->has('email'))
                <strong>{{ $errors->first('email') }}</strong>
            @endif
        </div>
    </div>
-->
    <div>
        <label for="password">Password</label>
        <div>
            <input type="password" name="password" id="password">
            @if ($errors->has('password'))
                <strong>{{ $errors->first('password') }}</strong>
            @endif
        </div>
    </div>

    <div>
        <label for="confirm">Confirm Password</label>
        <div>
            <input type="password" name="password_confirmation" id="confirm">
            @if ($errors->has('password_confirmation'))
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            @endif
        </div>
    </div>
    {!! app('captcha')->display(); !!}
    <div>
        <div>
            <button type="submit">
                Register
            </button>
        </div>
    </div>
</form>
@endsection
