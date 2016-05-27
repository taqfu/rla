<?php use app\User; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Do It! Prove It!</title>


    <!-- Styles -->
<!--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
-->
    <link rel="stylesheet" href="/rla/public/css.css">

</head>
<body>
    <nav>
        &nbsp;
        <div class='brand'>
            <a href="{{ url('/') }}" class='brand'>
                Do It! Prove It!
            </a>
        </div>
        <div class='right'>
                @if (Auth::guest())
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                @else
                                                         
                        <a href="{{ route('user.show', ['id'=>Auth::user()->id])}}">{{ Auth::user()->name }}</a>
                        @if (User::does_user_have_unread_msgs())
                            <a href="{{ route('inbox')}}">Inbox(!)</a>
                        @else
                            <a href="{{ route('inbox')}}">Inbox</a>
                        @endif
                            <a href="{{ url('/logout') }}">Logout</a>
                @endif
        </div>
        
        <div class='right feedback'>
            <a href="{{route('feedback')}}">Feedback</a>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src='/rla/public/js.js'></script>
</body>
</html>
