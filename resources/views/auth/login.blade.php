@extends('layouts.app')
@section ('title')
 - Login
@endsection
@section('content')
<div>
    <form method="POST" action="{{ url('/login') }}" style='display:inline-block;'>
        {!! csrf_field() !!}
        <div>
            <label for="username">Username</label>
            <div>
                <input type="username" name="username" value="{{ old('username') }}" id="username">
                @if ($errors->has('username'))
                    <strong>{{ $errors->first('username') }}</strong>
                @endif
            </div>
        </div>

        <div>
            <label for="password">Password</label>
<!--            <a href="{{ url('/password/reset') }}">(Reset)</a>-->
            <div>
                <input type="password" name="password" id="password">
                @if ($errors->has('password'))
                    <strong>{{ $errors->first('password') }}</strong>
                @endif
            </div>
        </div>
        <div>
                <button type="submit">
                    Login
                </button>
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
        </div>
    </form>
</div>
@endsection
