<?php use app\User; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Do It! Prove It!</title>


    <link rel="stylesheet" href="http://doitproveit.com/css.css">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-78588619-1', 'auto');
  ga('send', 'pageview');

</script>
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
            <a href="{{route('feedback')}}">Feedback</a>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src='http://doitproveit.com/js.js'></script>
</body>
</html>
