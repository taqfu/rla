
@extends ('layouts.app')
@section('title')
 - Real Life Achievements 
@endsection
@section ('content')
<div id='public-page'>
    <div class='container-flexible hidden'>
        <div class='row'>
            <div class='col-xs-4'></div>
            <div class='achievement-unlocked-container mobileHidden col-xs-4'>
                <div class='container-flexible'>
                    <div class='row'>
                        <div class='col-xs-2'>
                                <img src="{{url('/')}}/logo-42-2.png" >
                        </div>
                        <div class='achievement-unlocked-text-container col-xs-10'>
                            <div class='title text-center'>Achievement Unlocked</div>
                            <div class='description text-center'>You found a real life achievements site!</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-xs-4'></div>
        </div>
    </div>
    <div id='public-message' class='text-center' >
        <p>How many times have you thought to yourself...    </p>
        <p><strong><i>"I wish there were video game achievements for real life!"</i></strong></p>
        <p>
            <i>Do It! Prove It!</i> is an up-and-coming community for tracking and sharing your accomplishments.    
        </p> 
        <a href="{{route('achievement.index', Config::get('rla.default_filter') )}}">
            Check out the achievements available!
        </a>
    </div>
</div>
@endsection
