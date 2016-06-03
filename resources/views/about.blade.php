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
    <h4>Do It</h4>
    <ul>
        <li>
            <span class='bold'>Be specific.</span> If you lost weight, say how much. Be as specific as possible with the limited amount of characters that are available to you.
        </li>
        <li>
            <span class='bold'>Keep it short.</span> You have 100 characters for your achievement title, so keep it as short as possible.
        </li>
    </ul>
    <h4>Prove It</h4>
    <ul>
        <li>
            <span class='bold'>Post proof.</span> Whatever kind of proof you have, post it. If it's pictures, post it on <a href='http://imgur.com'>Imgur</a>. If it's a video, post it on <a href='http://youtube.com'>YouTube</a>. Whatever the proof is, just copy and paste post the link. <span class='bold'>Faking proof is a bannable offense.</span>
        </li>
        <li>
            <span class='bold'>Vote.</span> When you post your proof, the community will decide if your proof is adequate. If you're creating a new achievement, then everyone on the site can vote on it. If you're posting proof to an already created achievement, only those that have already completed it can vote. 
        </li>
    </ul>
     <h4>Voting Guidelines</h4>
     <p class='margin-left'>
        Ultimately, the way things are run will be decided by the community, but here are some general guidelines for voting:
     </p>
     <ul>
        <li>
            <span class='bold'>Don't be a dick.</span> People who are abusive will be banned from messaging, from commenting or, even, from the site.
        </li>
        <li>
            <p>
            <span class='bold'>Be charitable.</span> If the achievement is,"Lose five pounds." and the person lost only 4.5 pounds. Don't vote them down based on that.             
                It's important that we verify these accomplishments but it's also important to not nit-pick. Allegations that someone is faking proof should not be done lightly. 
            </p>
        </li>
    </ul>
    
@endsection
