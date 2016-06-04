
@extends ('layouts.app')
@section ('content')
<h2>Real Life Achievements</h2>
<div class='margin-left'>
    <p>How many times have you thought to yourself...    </p>
     <p class='center'><B><i>"I wish there were video game achievements for real life!"</i></b></p>

    <p>
        <i>Do It! Prove It!</i> is a real life achievement site. Other real life achievement sites take this in a different direction than <i>Do It! Prove It!</i> by letting you write whatever achievement you want. Scale Mount Everest? <strong>Achievement Unlocked.</strong> Go into space? <strong>Achievement Unlocked.</strong> 
    </p>
    <p>	
        We aren't that trusting. Just like in real life, we don't trust you. We don't believe you. Unless you have proof, you didn't do anything. And what's the point of being awesome and doing awesome things if no one believes you?
    </p>
    <p>
        That's what this site is for. It's your resume of awesome. <i>Do it! Prove it!</i>
    </p>
</div>
<p id='achievements_link'>
    <a href="{{route('achievement.index')}}"> Check out the achievements available!</a></p>
</p>
@endsection
