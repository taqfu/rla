<?php
    use App\Achievement;
    use App\Goal;
    use App\User;
    $filters = (session('filters')==null) 
      ? Config::get('rla.default_filter')
      : Achievement::process_filters(session('filters'));

    if (session('sort')!=null){
        $sort_arr = explode (" ", session('sort'));
        $filters = $filters . "&sort=" . $sort_arr[0] . "+" . $sort_arr[1];
    }
    if ($_SERVER['SERVER_NAME']=='taqfu.com'){
        $root_url = "http://taqfu.com/dev-env/rla/public";
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
    <meta name='description' content='Do It! Prove It! is a real life achievements site dedicated to tracking and sharing your accomplishments. Welcome to your resume of awesome!'>
    <meta name='keywords' content='real life achievements, bucket list, real world achievements, achievement unlocked'>

    <title>Do It! Prove It!@yield('title')</title>

    <link rel="apple-touch-icon" sizes="57x57" href="{{$root_url}}/img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{{$root_url}}/img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{$root_url}}/img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{$root_url}}/img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{$root_url}}/img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{$root_url}}/img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{{$root_url}}/img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{$root_url}}/img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{$root_url}}/img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{$root_url}}/img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{$root_url}}/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{$root_url}}/img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{$root_url}}/img/favicon-16x16.png">
    <link rel="manifest" href="{{$root_url}}/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{$root_url}}/img/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel='publisher' href='https://plus.google.com/u/0/b/111000706342354560427/111000706342354560427/about'>
    <link rel="stylesheet" href="{{$root_url}}/css/new-css.css">
    <link rel="stylesheet" href="{{$root_url}}/css/bootstrap.min.css">
@yield('head')
</head>
<body>
<div id="fb-root"></div>
<script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=104833379942261";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
    <nav id='app-nav' class='navbar navbar-default'>
        <div class='container-fluid'>
            <div class='navbar-header'>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class='navbar-brand' href="{{ url('/') }}" >
                    Do It! Prove It!
                </a>
            </div>
            <div class='collapse navbar-collapse' id='myNavbar'>
                <ul class='nav navbar-nav text-right'>
                    <li>
                        <a href="{{route('achievement.index', $filters)}}">
                            Achievements
                        </a>
                    </li>
                    <li>
                        <a href="{{route('goal.index')}}">
                            Bucket List
                            @if (Auth::user())
                            ({{count(Goal::where('user_id', Auth::user()->id)->whereNull('canceled_at')->get())}})
                            @endif
                        </a>
                    </li>
                </ul>
                <ul class='user-menu nav navbar-nav navbar-right text-right'>
                    @if (Auth::guest())
                    <li>
                    <a href="{{ url('/login') }}">Login</a>
                    </li>
                    <li>
                        <a href="{{ url('/register') }}">Register</a>
                    </li>
                    @else
                    <li class='username'>
                        <a href="{{ route('user.show', ['username'=>Auth::user()->username])}}">{{ Auth::user()->username }}({{Auth::user()->score}})</a>
                    </li>
                    <li>
                        @if (User::does_user_have_unread_msgs())
                        <a href="{{ route('inbox')}}" style='color:red;'>
                        @else
                        <a href="{{ route('inbox')}}">
                        @endif
                            <span class='glyphicon glyphicon-envelope'></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}">
                            Logout
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

    </nav>
    <div id='content'>
    @yield('content')
    </div>
    <div>
        <footer>
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-xs-6'>
                        {{count(Achievement::get())}} Achievements
                    </div>
                    <div class='col-xs-6 text-right'>
                        {{count(User::get())}} Users
                    </div>
                </div>
            </div>
            <div class='container-fluid'>
                <div class='row'>

                    <div class='col-xs-4 text-right'>
	                    <a href="{{route('guidelines')}}">Guidelines</a>
                    </div>
                    <div class='col-xs-4 text-center'>
                        <a href="{{route('changes')}}">Changelist</a>
                    </div>
                    <div class='col-xs-4 text-left'>
                        <a href="{{route('feedback')}}">Feedback</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- JavaScripts -->
    <script src="{{$root_url}}/js/jquery-2.2.4.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{$root_url}}/js/bootstrap.min.js"></script>
    <script src="{{$root_url}}/js/js.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-78588619-1', 'auto');
  ga('send', 'pageview');

</script>

<script
    type="text/javascript"
    async defer
    src="//assets.pinterest.com/js/pinit.js"
></script>
</body>
</html>
