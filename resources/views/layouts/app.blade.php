<?php use app\User; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Do It! Prove It!@yield('title')</title>
    @if ($_SERVER['SERVER_NAME']=='taqfu.com')
    <link rel="stylesheet" href="http://taqfu.com/rla-dev/rla/public/css.css">
    @elseif ($_SERVER['SERVER_NAME']=='doitproveit.com')
    <link rel="stylesheet" href="http://doitproveit.com/css.css">
    @endif
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

@yield('head')
</head>
<body>
    <nav id='app_nav'>
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
                                                         
                        <a href="{{ route('user.show', ['id'=>Auth::user()->id])}}">{{ Auth::user()->username }}</a>
                        @if (User::does_user_have_unread_msgs())
                            <a href="{{ route('inbox')}}">Inbox(!)</a>
                        @else
                            <a href="{{ route('inbox')}}">Inbox</a>
                        @endif
                            <a href="{{ url('/logout') }}">Logout</a>
                @endif
        </div>
        
        <div class='right feedback'>
	    <a href="{{route('about')}}">About</a>
            <a href="{{route('feedback')}}">Feedback</a>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    @if ($_SERVER['SERVER_NAME']=='taqfu.com')
    <script src="http://taqfu.com/rla-dev/rla/public/js.js"></script>
    @elseif ($_SERVER['SERVER_NAME']=='doitproveit.com')
    <script src="http://doitproveit.com/js.js"></script>
    @endif
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-78588619-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
