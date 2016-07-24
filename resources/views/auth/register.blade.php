@extends('layouts.app')
@section('title')
 - Register
@endsection
@section('content')
<div class='margin-left col-xs-6'>
    <form  method="POST" action="{{ url('/register') }}" class='margin-left' role='form'>
    @foreach ($errors->all() as $error)
        <div class='text-danger'>{{$error}}</div>
    @endforeach
        {!! csrf_field() !!}
        <div class='form-group'>
            <label for="username">Username</label>
            <div>
                <input type="text" name="username" value="{{ old('username') }}" id="username" class='form-control'>
                @if ($errors->has('username'))
                <div class='text-danger'>{{ $errors->first('username') }}</div>
                @endif
            </div>
        </div>
        <div class='form-group'>
            <label for="email">E-Mail Address (optional)</label>
            @if (isset($registered_email))

            @else
            <div>
                <input type="email" name="email" value="{{ old('email') }}" id="email" 
                  class='form-control'>
                @if ($errors->has('email'))
                <div class='text-danger'>{{ $errors->first('email') }}</div>
                @endif
            </div>
            @endif
        </div>
        <div class='form-group'>
            <label for="password">Password</label>
            <div>
                <input type="password" name="password" id="password" class='form-control'>
                @if ($errors->has('password'))
                <div class='text-danger'>{{ $errors->first('password') }}</div>
                @endif
            </div>
        </div>
    
        <div class='form-group'>
            <label for="confirm">Confirm Password</label>
            <div>
                <input type="password" name="password_confirmation" id="confirm" class='form-control'>
                @if ($errors->has('password_confirmation'))
                <div class='text-danger'>{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>
        </div>
        <div class='form-group'>
        {!! app('captcha')->display(); !!}
        </div>
        <div class='form-group'>
            <button type="submit">
                Register
            </button>
        </div>
    </form>
</div>
@endsection
