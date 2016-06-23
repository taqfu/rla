
@extends ('layouts.app')
@section('title')
 - Real Life Achievements 
@endsection
@section ('content')
<div id='public-page'>
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
