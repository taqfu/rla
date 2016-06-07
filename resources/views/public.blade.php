
@extends ('layouts.app')
@section('title')
 - Real Life Achievements 
@endsection
@section ('content')
<h2>Real Life Achievements</h2>
<!--
<div class='achievement-unlocked-container'>
    <div class='caption'>Achievement Unlocked</div>
</div>
-->
<div id='public_message' class='margin-left'>
    <p class='center'>How many times have you thought to yourself...    </p>
     <p class='center'><B><i>"I wish there were video game achievements for real life!"</i></b></p>

    <p class='center'>
        <i>Do It! Prove It!</i> is a real life achievement site. It's a place to showcase all of your achievements and meet people with similar accomplishments.
    </p>
    <p>
        Welcome to your resume of awesome! <i>Do it! Prove it!</i>
    </p>
    <p id='achievements_link'>
        <a href="{{route('achievement.index')}}"> Check out the achievements available!</a></p>
    </p>
</div>
@endsection
