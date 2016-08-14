@extends('layouts.app')
@section ('title')
 - Login
@endsection
@section('content')
<div class='margin-left col-xs-6'>
    <form method="POST" action="{{ url('/login') }}" role='form' >
        {!! csrf_field() !!}
        <div class='form-group'>
            <label for="username">Username</label>
            <div>
                <input type="username" name="username" value="{{ old('username') }}" id="username" class='form-control'>
                <div class='text-danger'>
                @if ($errors->has('username'))
                {{ $errors->first('username') }}
                @endif
                </div>
            </div>
        </div>

        <div class='form-group'>
            <label for="password">Password</label>
-            <a href="{{ url('/password/reset') }}">(Reset)</a>
            <div>
                <input type="password" name="password" id="password" class='form-control'>
                <div class='text-danger'>
                    @if ($errors->has('password'))
                        {{ $errors->first('password') }}
                    @endif
                </div>
            </div>
        </div>
        <div class='form-group'>
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
