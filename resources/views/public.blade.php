
@extends ('layouts.app')
@section('title')
 - Real Life Achievements 
@endsection
@section ('content')
<div id='public_page'>
    <div class='achievement-unlocked-container mobileHidden '>
        <div class='inline'>
            <div class='achievement-unlocked-icon-container'>
                <img src="{{url('/')}}/logo-42-2.png" >
            </div>
        </div>
        <div class='achievement-unlocked-text-container'>
            <div class='title'>Achievement Unlocked</div>
            <div class='description'>You found a real life achievements site!</div>
        </div>
    </div>
    <div id='public_message' >
        <p class='center'>How many times have you thought to yourself...    </p>
         <p class='center'><B><i>"I wish there were video game achievements for real life!"</i></b></p>
    
        <p class='center'>
            <i>Do It! Prove It!</i> is an up-and-coming community for tracking and sharing your accomplishments.    
        </p> 
        <h2 id='achievements_link'>
            <a href="{{route('achievement.index')}}"> Check out the achievements available!</a></p>
        </h2>
    </div>
</div>
@endsection
