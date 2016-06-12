<?php 
    use App\Achievement;
    use App\User; 
    if ($_SERVER['SERVER_NAME']=='taqfu.com'){
        $root_url = "http://taqfu.com/rla-dev/rla/public";
    } else if ($_SERVER['SERVER_NAME']=='doitproveit.com' || $_SERVER['SERVER_NAME']=='www.doitproveit.com'){
        $root_url = "http://doitproveit.com";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='description' content='Welcome to your resume of awesome! Do It! Prove It! is a real life achievements site dedicated to tracking and sharing your accomplishments. Show the world how awesome you are.'>
    <meta name='keywords' content='real life achievement, real world achievement, achievement unlocked'>
    
    <title>Do It! Prove It!@yield('title')</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{$root_url}}/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{{$root_url}}/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{$root_url}}/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{$root_url}}/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{$root_url}}/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{$root_url}}/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{{$root_url}}/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{$root_url}}/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{$root_url}}/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{$root_url}}/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{$root_url}}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{$root_url}}/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{$root_url}}/favicon-16x16.png">
    <link rel="manifest" href="{{$root_url}}/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{$root_url}}/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel='publisher' href='https://plus.google.com/u/0/b/111000706342354560427/111000706342354560427/about'>
    <link rel="stylesheet" href="{{$root_url}}/css.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

@yield('head')
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=104833379942261";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <nav id='app_nav' class='center'>
        &nbsp;
        <div class='brand left'>
            <a href="{{ url('/') }}" class='brand'>
                Do It! Prove It!
            </a>
        </div>
        <div id='user_menu'>
            <a href="{{route('achievement.index')}}">Achievements</a>
            -
                @if (Auth::guest())
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                @else
                        <a href="{{ route('inventory') }}">Inventory</a>
                                                         
                        <a href="{{ route('user.show', ['id'=>Auth::user()->id])}}">{{ Auth::user()->username }}({{Auth::user()->score}})</a>
                        @if (User::does_user_have_unread_msgs())
                            <a href="{{ route('inbox')}}" class='unread'>Inbox(!)</a>
                        @else
                            <a href="{{ route('inbox')}}">Inbox</a>
                        @endif
                            <a href="{{ url('/logout') }}">Logout</a>
                @endif
        </div>
        
    </nav>
    <div id='content'>
    @yield('content')
    </div>
    <div>
    <footer>
        <div class='left margin-left'>  
            {{count(Achievement::get())}} Achievements
        </div>
        <div class='right margin-right'>
            {{count(User::get())}} Users
        </div>
        <div id='center-footer'>
	        <a href="{{route('about')}}">About Us</a>
            <a href="{{route('changes')}}">Changelist</a>
            <a href="{{route('feedback')}}">Feedback</a>
        </div>
    </footer>
    </div>
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
